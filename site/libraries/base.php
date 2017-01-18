<?php

/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 * @since       0.0.1
 */
abstract class NyccEventsObjBase {
    /**
     * An array of child objects definitions.  Each key is the name of the
     * object, and the element is an array of:
     *   'list_model' => name of the Model to use for the list
     *   'item_model' => name of the Model to use for each item
     *   'fk'         => foreign key field
     *   'fk_value'   => for loading, the specific value of the foreign key to search
     * Example: 'venues' => array('list_model'=>'Venues', 'item_model'=>'Venue', 'fk'=>'event_id')
     * This should be set in the extended class definition or __construct()
     *
     * @var array
     * @since 0.0.1
     */
    protected $_children = array();

    /**
     * Store for child objects/data
     *
     * @var array
     * @since 0.0.1
     */
    protected $_child_data = array();

    /**
     * The loaded data, as in the return of JModelLegacy->getItem()
     *
     * @var array
     * @since 0.0.1
     */
    protected $_data = array();

    /**
     * Easy reference property holding parsed type/name from class name
     *
     * @var object
     * @see   NyccEventsHelperUtils::getObjectType()
     * @since 0.0.1
     */
    protected $_self_type = NULL;

    /**
     * Indicating if child objects should be loaded with the item.  Can be set
     * to load just the child, or recursively load grandchildren as well (default).
     *
     * @var int
     * @since 0.0.1
     */
    public $load_children = NYCCEVENTS_LOAD_RECURSIVE;

    /**
     * General purpose internal cache
     *
     * @var array()
     * @since 0.0.1
     */
    protected $_cache = array();

    /**
     * An array of default prefixes to use when instantiating child models.  Each
     * key is a possible type, with each value being the prefix.
     *
     * @var array
     * @since 0.0.1
     */
    protected $_model_prefix = array(
        'item' => 'Obj',
        'list' => 'Model',
    );

    /**
     * @param string $index   The (optional) index to use
     * @param mixed  $default The default value to return if index is not found
     *
     * @return mixed
     * @since 0.0.1
     */
    protected function _get_cache($index = '', $default = NULL) {
        return array_key_exists($index, $this->_cache) ? $this->_cache[$index] : $default;
    }

    /**
     * @param array  $value The value to set
     * @param string $index The (optional) index to use
     *
     * @since 0.0.1
     */
    protected function _set_cache($value, $index = '') {
        $this->_cache[$index] = $value;
    }

    /**
     * NyccEventsObjBase constructor.
     *
     * @param array $config
     *
     * @since 0.0.1
     */
    public function __construct($item_id = NULL, Array $config = array()) {
        $this->_self_type = NyccEventsHelperUtils::getObjectType($this);

        if (isset($config['load_children'])) {
            $this->load_children = (integer) $config['load_children'];
        }

        if ($item_id) {
            $this->load($item_id);
        }
    }

    /**
     * @param $name
     *
     * @return mixed|null
     *
     * @since 0.0.1
     */
    public function __get($name) {
        if (isset($this->_data->{$name})) {
            return $this->_data->{$name};
        }
        elseif (isset($this->_children[$name]) && isset($this->_child_data[$name])) {
            return $this->_child_data[$name];
        }
        else {
            return NULL;
        }
    }

    /**
     * @param string $model_type
     *
     * @return string
     *
     * @since 0.0.1
     */
    public function getChildModelPrefix($model_type = 'item') {
        $model_type = \Joomla\Utilities\ArrayHelper::getValue(
            $this->_model_prefix,
            $model_type,
            'Model'
        );

        return 'NyccEvents' . $model_type;
    }

    /**
     * Gets an instance of a child's model.  The child must exist, and have a
     * definition for the model_type being requested.
     *
     * @param string $model_name The name of the model, e.g., 'Event', 'Venue'.
     * @param string $model_type E.g., 'list' or 'item'.
     * @param array  $config     A config array to be passed to the model's __construct().
     *
     * @return \JModelLegacy|null
     *
     * @since 0.0.1
     */
    public function getChildModel($model_name, $model_type = 'item', $config = array()) {
        // Initialize the return.
        $the_model = NULL;

        // The child object must be defined.
        if (array_key_exists($model_name, $this->_children)) {
            // Get the prefix for the model's name.
            $model_prefix = $this->getChildModelPrefix($model_type);

            // Instantiate the model
            $model_name = $this->_children[$model_name][$model_type . '_model'];
            try {
                $the_model = JModelLegacy::getInstance($model_name, $model_prefix, $config);
            }
            catch (Exception $e) {
                NyccEventsHelperUtils::setAppError($e->getMessage());
            }
        }

        return $the_model;
    }

    /**
     * Clear current data from this object.
     *
     * @since 0.0.1
     */
    public function clear() {
        $this->_data       = NULL;
        $this->_child_data = array();
    }

    /**
     * Creates and returns a model for this object.
     *
     * @return bool|NyccEventsModelBase
     *
     * @since 0.0.1
     */
    public function getModel() {
        // Get the model
        try {
            $model = JModelLegacy::getInstance($this->_self_type->name, 'NyccEventsModel');
        }
        catch (Exception $e) {
            NyccEventsHelperUtils::setAppError($e->getMessage());

            return FALSE;
        }

        return $model;
    }

    /**
     * Method to get a single record.  Collection objects have subobject properties.
     *
     * @param   integer|array $pk The id of the primary key, or an array of pre-loaded data.
     *
     * @since   0.0.1
     *
     * @see     JModelAdmin
     */
    public function load($pk = NULL, $load_children = NULL) {
        // Clear all current data.
        $this->clear();

        // Get the model.
        $model = $this->getModel();

        // Get the row data
        if (is_array($pk) || is_object($pk)) {
            $this->_data = $model::translateTableToObject($pk);
        }
        else {
            $this->_data = $model->getItem($pk);
        }

        if (is_null($load_children)) {
            $load_children = $this->load_children;
        }

        // if parent item exists
        if ($load_children && !empty($this->_data->id) && count($this->_children)) {
            // load each subgroup
            $this->loadAllChildren($load_children);
        }
    }

    /**
     * Loads a single group of a defined child
     *
     * @param         $type
     * The type of child to load.  Must be a key in $_children.
     *
     * @param integer $load_children
     * Flag indicating if loading should recurse into children.
     *
     * @return boolean FALSE on failure
     *
     * @since 0.0.1
     */
    public function loadChild($type, $load_children = NULL) {
        // If the parent has no data, nothing to do.
        if (!isset($this->_data->id)) {
            return FALSE;
        }

        // If the child is not defined, nothing to do.
        if (!isset($this->_children[$type])) {
            return FALSE;
        }

        // Reference to the sub-table
        $sub_table = $this->_children[$type];

        // Validate the sub-table config
        if (empty($sub_table['fk'])) {
            NyccEventsHelperUtils::setAppError("Sub-table '$type' was not populated.  See " . __FILE__);

            return FALSE;
        }

        // set up the list model config (set filter, set state)
        $list_config = array(
            'ignore_request' => TRUE,
            'filter_fields'  => array($sub_table['fk'] => $this->_data->id)
        );

        // Get the child list model, and set the state limit for all records
        $list_model = $this->getChildModel($type, 'list', $list_config);
        $list_model->setState('list.limit', 0);

        // iterate through found items, and create objects for them
        $list_of_models = $list_model->getItems();
        if (is_array($list_of_models)) {
            // If the load_children setting is not passed, make sure recursion is inherited.
            if (is_null($load_children)) {
                $load_children = ($this->load_children == NYCCEVENTS_LOAD_RECURSIVE) ? $this->load_children : 0;
            }

            // Propagate the load_children setting
            $config = array('load_children' => $load_children);

            // Get the item object class name
            $item_model_name = "NyccEventsObj" . ucfirst($sub_table['item_model']);

            // Iterate through the returned data and load each item
            foreach ($list_of_models as $key => $val) {
                $one_item                     = new $item_model_name($val, $config);
                $this->_child_data[$type][] = $one_item;
            }
        }

        return TRUE;
    }

    /**
     * Loads all children defined in $this->_children
     *
     * @param null $load_children
     *     Indicates if loading cascades.  If not passed, will be set to
     *     load grandchildren only if this object is set to use recursion.
     *
     * @since 0.0.1
     */
    public function loadAllChildren($load_children = NULL) {
        // If the load_children setting is not passed, make sure recursion is inherited.
        if (is_null($load_children)) {
            $load_children = ($this->load_children == NYCCEVENTS_LOAD_RECURSIVE) ? $this->load_children : 0;
        }

        // Iterate through the children, loading each.
        foreach ($this->_children as $type => $subtable) {
            $this->loadChild($type, $load_children);
        }
    }
}