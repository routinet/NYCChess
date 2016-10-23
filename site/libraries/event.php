<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 * @since       0.0.1
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */


class NyccEventsObjEvent extends NyccEventsObjBase {

  protected $_children = array(
    'venues' => array('list_model'=>'Venues', 'item_model'=>'Venue', 'fk'=>'event_id'),
    );

  public function loadPrimaryLocation() {
    if (isset($this->_data->main_location)) {
      $this->_data->location = JModelLegacy::getInstance('location', 'NyccEventsModel')
        ->getItem($this->_data->main_location);
    }
  }

  public function getVenueLocations() {
    // Initialize the return
    $ret = array();

    // Iterate through all loaded venues and compile the locations
    if (is_array($this->_child_data['venues'])) {
      foreach ($this->_child_data['venues'] as $k1 => $venue) {
        $ret[$venue->location_id] = $venue->location_name;
      }
    }

    return $ret;
  }

  public function getVenuesByRate() {
    $ret = array('_all' => array());
    if (is_array($this->_child_data['venues'])) {
      foreach ($this->_child_data['venues'] as $k1 => $venue) {
        $ret['_all'][] = $venue;
        foreach ($venue->rates as $k2 => $rate) {
          if (!array_key_exists($venue->rate_label, $ret)) {
            $ret[$rate->rate_label] = array();
          }
          $ret[$rate->rate_label][] = $venue;
        }
      }
    }

    return $ret;
  }
}