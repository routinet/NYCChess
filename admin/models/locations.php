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
class NycceventsModelLocations extends JModelList {
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
      ->from($db->quoteName('#__nycc_locations'));

    return $query;
  }
}