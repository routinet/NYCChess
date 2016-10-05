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
 * Venue Rate Model
 *
 * @since  0.0.1
 */
class NyccEventsModelVenueRate extends NyccEventsModelBaseMultilevel {
  /**
   * Constructor.
   *
   * @param   array  $config  An optional associative array of configuration settings.
   *
   * @see     JModelLegacy
   * @since   0.0.1
   */
  public function __construct($config = array()) {
    $this->_lookups = array(
      'venue' => array('field'=>'venue_id', 'table'=>'venues', 'lookup'=>'display_name'),
      'rate' => array('field'=>'rate_id', 'table'=>'rates', 'lookup'=>'label'),
    );
    parent::__construct($config);
  }
}