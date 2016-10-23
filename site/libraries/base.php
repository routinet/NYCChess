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
   * @see NyccEventsHelperUtils::getObjectType()
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
   *
   * @param       $model_name
   * @param array $config
   *
   * @return bool
   *
   * @since 0.0.1
   */
  public function getChildListModel($model_name, $config = array()) {
    // The child object must be defined.
    if (!array_key_exists($model_name, $this->_children)) {
      return false;
    }

    // instantiate the list model
    $model_name = $this->_children[$model_name]['list_model'];
    try {
      $list_model = JModelLegacy::getInstance($model_name, 'NyccEventsModel', $config);
    }
    catch (Exception $e) {
      NyccEventsHelperUtils::setAppError($e->getMessage());
      return FALSE;
    }

    return $list_model;
  }

  /**
   * Clear current data from this object.
   *
   * @since 0.0.1
   */
  public function clear() {
    $this->_data = NULL;
    $this->_child_data = array();
  }

  /**
   * Method to get a single record.  Collection object have subobject properties
   *
   * @param   integer  $pk  The id of the primary key.
   *
   * @since   0.0.1
   *
   * @see     JModelAdmin
   */
  public function load($pk = null) {
    // Clear all current data.
    $this->clear();

    // Get the model
    //$model_name = static::_getClassName('model', $this->_self_type->name);
    try {
      $model = JModelLegacy::getInstance($this->_self_type->name, 'NyccEventsModel');
    }
    catch (Exception $e) {
      NyccEventsHelperUtils::setAppError($e->getMessage());
      return;
    }

    // Get the row data
    $this->_data = $model->getItem($pk);

    // if parent item exists
    if ($this->load_children && !empty($this->_data->id) && count($this->_children)) {
      // load each subgroup
      $this->loadAllChildren();
    }
  }

  /**
   * Loads a single group of a defined child
   * @param      $type
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
      return false;
    }

    // If the child is not defined, nothing to do.
    if (!isset($this->_children[$type])) {
      return false;
    }

    // Reference to the sub-table
    $sub_table = $this->_children[$type];

    // Validate the sub-table config
    if (empty($sub_table['fk'])) {
      NyccEventsHelperUtils::setAppError("Sub-table '$type' was not populated.  See " . __FILE__);
      return false;
    }

    // set up the list model config (set filter, set state)
    $list_config = array(
      'ignore_request' => TRUE,
      'filter_fields'  => array($sub_table['fk'] => $this->_data->id)
    );

    // Get the child list model, and set the state limit for all records
    $list_model = $this->getChildListModel($type, $list_config);
    $list_model->setState('list.limit', 0);

    // iterate through found items, and create objects for them
    $list_of_models = $list_model->getItems($list_config);
    if (is_array($list_of_models)) {
      // Get the item object class name
      $item_model_name = "NyccEventsObj" . ucfirst($sub_table['item_model']);

      // If the load_children setting is not passed, make sure recursion is inherited.
      if (is_null($load_children)) {
        $load_children = ($this->load_children == NYCCEVENTS_LOAD_RECURSIVE) ? $this->load_children : 0;
      }

      // Propagate the load_children setting
      $config = array('load_children' => $load_children);

      // Iterate through the returned data and load each item
      foreach ($list_of_models as $key => $val) {
        $newone = new $item_model_name($val->id, $config);
        $this->_child_data[$type][] = $newone;
      }
    }

    return true;
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