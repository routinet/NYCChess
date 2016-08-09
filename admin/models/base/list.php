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
 * NyccEventList Model
 *
 * @since  0.0.1
 */
class NyccEventsModelBaseList extends JModelList {
  /**
   * The physical table name for this model
   *
   * @var string
   * @since 0.0.1
   */
  protected $_table_name = '';

  /**
   * NyccEventsModelBaseList constructor.
   *
   * @param array $config
   * @since 0.0.1
   */
  public function __construct(array $config) {
    if (!$this->_table_name) {
      throw new RuntimeException(get_called_class() . " failed to identify its table");
    }
    parent::__construct($config);
  }

  /**
   * Method to build an SQL query to load the list data.
   * TODO: this method should use $this->state properly
   *
   * @since  0.0.1
   * @return      string  An SQL query
   */
  protected function getListQuery() {
    // Initialize variables.
    $query = $this->_db->getQuery(true);

    // Create the base select statement.
    $query->select('*')->from($query->quoteName("#__nycc_{$this->_table_name}"));

    if ($this->filter_fields) {
      $query = NyccEventsHelperUtils::addFilterConditions($query, $this->filter_fields);
    }

    return $query;
  }
}