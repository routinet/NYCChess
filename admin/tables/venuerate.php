<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * VenueRate Table class
 *
 * @since  0.0.1
 */
class NyccEventsTableVenueRate extends NyccEventsTableBaseTable {

  protected $_table_name = 'venue_rates';
  protected $boolint_fields = array('active');

}