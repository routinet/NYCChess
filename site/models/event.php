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
 * Event Model
 *
 * @since  0.0.1
 */
class NyccEventsModelEvent extends NyccEventsModelBaseMultilevel {
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
      'venues' => array('list_model'=>'Venues', 'item_model'=>'Venue', 'fk'=>'event_id'),
    );
    $this->_lookups = array(
      'location' => array('field'=>'main_location', 'table'=>'locations', 'lookup'=>'name'),
    );
    parent::__construct($config);
  }

}