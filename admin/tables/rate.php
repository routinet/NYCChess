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
 * Rate Table class
 *
 * @since  0.0.1
 */
class NyccEventsTableRate extends NyccEventsTableBaseTable {

  protected $_table_name = 'rates';
  protected $_boolean_fields = array('is_multiplier','active');

}