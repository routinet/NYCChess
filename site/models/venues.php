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
 * Venues List Model
 *
 * @since  0.0.1
 */
class NyccEventsModelVenues extends NyccEventsModelBaseList {
  protected $_table_name = 'venues';

  /**
   * Override in child to modify the query object
   *
   * @param JDatabaseQuery object
   * @since 0.0.1
   */
  protected function addQueryRelations(&$query) {
    $query->join('INNER',"#__nycc_events events on events.id=main.event_id")
      ->join('INNER',"#__nycc_locations locations on locations.id=main.location_id")
      ->select(array("events.name as event_name","locations.name as location_name"));
  }

}