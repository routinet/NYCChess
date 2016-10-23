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
class NyccEventsModelEvent extends NyccEventsModelBase {

  protected $_lookups = array(
    'location' => array('field'=>'main_location', 'table'=>'locations', 'lookup'=>'name'),
    );

}