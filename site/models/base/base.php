<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Base Model
 *
 * @since  0.0.1
 */
abstract class NyccEventsModelBase extends JModelLegacy {

    /**
     * Holds definitions of lookups fields.  It is keyed by identifiers for
     * the resulting fields.  Each element is itself an array, consisting of:
     *     'field'  => <FK field>
     *     'table'  => <Lookup table>
     *     'lookup' => <Lookup table field name>
     * Event Example:
     *   'event' => array('field'=>'main_location', 'table'=>'locations', 'lookup'=>'name')
     *
     * @var array
     * @since 0.0.1
     */
    protected $_lookups = array();

    /**
     * Easy reference property holding parsed type/name from class name
     *
     * @var bool|mixed
     * @see   NyccEventsHelperUtils::getObjectType()
     * @since 0.0.1
     */
    public $self_type = FALSE;

    /**
     * Constructor.
     *
     * @param   array $config An optional associative array of configuration settings.
     *
     * @see     JModelLegacy
     * @since   0.0.1
     */
    public function __construct($config = array()) {
        parent::__construct($config);

        $this->self_type = NyccEventsHelperUtils::getObjectType($this);
    }

    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string $type   The table name. Optional.
     * @param   string $prefix The class prefix. Optional.
     * @param   array  $config Configuration array for model. Optional.
     *
     * @return  NyccEventsTableBaseTable  A JTable object
     *
     * @since   0.0.1
     */
    public function getTable($type = '', $prefix = 'NyccEventsTable', $config = array()) {
        if (!$type && $this->self_type) {
            $type = $this->self_type->name;
        }

        return NyccEventsTableBaseTable::getInstance($type, $prefix, $config)
            ->setLookups($this->_lookups);
    }

    /**
     * Method to get a single record.  This customization is to allow for
     * intuitive binding with lookup fields, defined in $this->_lookups
     *
     * @param   integer $pk The id of the primary key.
     *
     * @return  mixed    Object on success, false on failure.
     *
     * @see     JModelAdmin::getItem
     *
     * @since   0.0.1
     */
    public function getItem($pk = NULL) {
        // Get the PK to load.  Looked for passed value, GET value, or state value.
        if (!$pk) {
            $pk = JFactory::getApplication()->input->get('id');
        }
        $pk = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');

        // Get the table and load the item.
        $table = $this->getTable();
        if (!empty($pk)) {
            $table->load($pk);
        }

        $item = static::translateTableToObject($table);

        if (!$item && (int) $pk) {
            NyccEventsHelperUtils::setAppError("getItem() failed to load PK=$pk");

            return FALSE;
        }

        return $item;
    }

    /**
     * Utility function to implement Joomla's default post-load translation.
     * All this really does is strip the JTable-specific methods/properties and
     * return a "clean" JObject with the data.
     *
     * @param JTable|Array $table The already-bound table from which data is drawn.
     *
     * @return \JObject The translated object.
     *
     * @since 0.0.1
     */
    public static function translateTableToObject($table) {
        // If an array is passed, cast it into JObject.
        if (!is_subclass_of($table, 'JObject')) {
            $table = new JObject($table);
        }

        // Get the data properties.
        $properties = $table->getProperties(1);

        // Cast into a standard JObject.
        $item = \Joomla\Utilities\ArrayHelper::toObject($properties, 'JObject');

        if (property_exists($item, 'params')) {
            $registry = new Registry;
            $registry->loadString($item->params);
            $item->params = $registry->toArray();
        }

        return $item;
    }
}