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
 * Venue Model
 *
 * @since  0.0.1
 */
class NyccEventsModelVenue extends NyccEventsModelBaseMultilevel {
  /**
   * Constructor.
   *
   * @param   array  $config  An optional associative array of configuration settings.
   *
   * @see     JModelLegacy
   * @since   0.0.1
   */
  public function __construct($config = array()) {
    $this->_joins = array(
      'rates' => array('list_model'=>'Venuerates', 'item_model'=>'Venuerate', 'fk'=>'venue_id'),
    );
    $this->_lookups = array(
      'event' => array('field'=>'event_id', 'table'=>'events', 'lookup'=>'name'),
      'location' => array('field'=>'location_id', 'table'=>'locations', 'lookup'=>'name'),
    );
    parent::__construct($config);
  }

}