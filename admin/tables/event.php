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
 * Event Table class
 *
 * @since  0.0.1
 */
class NyccEventsTableEvent extends NyccEventsTableBaseTable {

  protected $_table_name = 'events';
  public $boolint_fields = array('active');

}