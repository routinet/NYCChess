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

  /**
   * @param       $data
   *     An array of the Venue row to save, e.g., form data.
   * @param array $rates
   *     Array of rate_id values to add to this Venue.
   *
   * @return bool
   *     Returns false if either the parent record INSERT or the
   *     child mass INSERT fails.
   *
   * @since 0.0.1
   */
  public function addFullVenue($data, Array $rates = array()) {
    // First, save the record and note the success
    $ret = $this->save($data);

    // If all good, save the rate records
    if ($ret && count($rates)) {
      // Save the rates.  Do a mass INSERT to save cycles.
      $query = $dbo->getQuery(TRUE);
      $query->insert('#__nycc_venue_rates')
        ->columns('venue_id,rate_id');
      foreach ($rates as $key=>$val) {
        $query->values($this->getState('venue.id') . ',' . $val);
      }
      $dbo->setQuery($query);
      $ret &= $dbo->execute();
    }

    // Return the overall success
    return $ret;
  }
}