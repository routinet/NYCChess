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
class NyccEventsTableLocation extends JTable
{
  /**
   * Constructor
   *
   * @since  0.0.1
   * @param   JDatabaseDriver  &$db  A database connector object
   */
  function __construct(&$db)
  {
    parent::__construct('#__nycc_locations', 'id', $db);
  }

  public function bind($src, $ignore = array()){
    if (!array_key_exists('published', $src)) {
      $src['published'] = 0;
    }
    return parent::bind($src, $ignore);
  }
}