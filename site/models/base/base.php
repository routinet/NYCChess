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
   * Holds definitions of lookups fields.
   * Event Example: array('field'=>'main_location', 'table'=>'locations', 'lookup'=>'name')
   *
   * @var array
   * @since 0.0.1
   */
  protected $_lookups = array();

  /**
   * Easy reference property holding parsed type/name from class name
   *
   * @var bool|mixed
   * @see NyccEventsHelperUtils::getObjectType()
   * @since 0.0.1
   */
  public $self_type = false;

  /**
   * Constructor.
   *
   * @param   array  $config  An optional associative array of configuration settings.
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
   * @param   string  $type    The table name. Optional.
   * @param   string  $prefix  The class prefix. Optional.
   * @param   array   $config  Configuration array for model. Optional.
   *
   * @return  JTable  A JTable object
   *
   * @since   0.0.1
   */
  public function getTable($type = '', $prefix = 'NyccEventsTable', $config = array()) {
    if (!$type && $this->self_type) {
      $type = $this->self_type->name;
    }
    return JTable::getInstance($type, $prefix, $config);
  }

  /**
   * Method to get a single record.  This customization is to allow for
   * intuitive binding with lookup fields, defined in $this->_lookups
   *
   * @param   integer  $pk  The id of the primary key.
   *
   * @return  mixed    Object on success, false on failure.
   *
   * @see JModelAdmin::getItem
   *
   * @since   0.0.1
   */
  public function getItem($pk = null) {
    // Get the PK to load.  Looked for passed value, GET value, or state value.
    if (!$pk) {
      $pk = JFactory::getApplication()->input->get('id');
    }
    $pk = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');

    // get the table for this model
    $table = $this->getTable();

    // get the query oject used to load data
    $query = $table->getTableQuery($pk);

    // if $query is false, return false
    if ($query === false) {
      return false;
    }

    // add each join to the query
    foreach ($this->_lookups as $key=>$lookup) {
      // array('field'=>'main_location', 'table'=>'locations', 'lookup'=>'name')
      $join = "#__nycc_{$lookup['table']} as {$lookup['table']} ON " .
        "main.{$lookup['field']}={$lookup['table']}.id";
      $select = "{$lookup['table']}.{$lookup['lookup']} " .
        "as {$key}_{$lookup['lookup']}";
      $query->join('INNER', $join)->select($select);
    }

    $row = $this->_getList($query);
    if (count($row)) {
      $row = $row[0];
    } elseif ((int) $pk) {
      NyccEventsHelperUtils::setAppError("getItem() failed to load PK=$pk");
      return false;
    }

    return $row;
  }

}