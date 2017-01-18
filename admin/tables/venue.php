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
 * Venue Table class
 *
 * @since  0.0.1
 */
class NyccEventsTableVenue extends NyccEventsTableBaseTable {

  protected $_table_name = 'venues';
  protected $_boolean_fields = array('active');

}