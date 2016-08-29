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
 * Location Table class
 *
 * @since  0.0.1
 */
class NyccEventsTableLocation extends NyccEventsTableBaseTable {

  protected $_table_name = 'locations';
  protected $boolint_fields = array('active');

}