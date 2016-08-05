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
  protected $_table_name = '';

  public function __construct(array $config) {
    if (!$this->_table_name) {
      throw new RuntimeException(get_called_class() . " failed to identify its table");
    }
    parent::__construct($config);
  }

  /**
   * Method to build an SQL query to load the list data.
   *
   * @since  0.0.1
   * @return      string  An SQL query
   */
  protected function getListQuery() {
    // Initialize variables.
    $db    = JFactory::getDbo();
    $query = $db->getQuery(true);

    // Create the base select statement.
    $query->select('*')
      ->from($db->quoteName("#__nycc_{$this->_table_name}"));

    return $query;
  }
}