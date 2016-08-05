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
 * General helper class
 *
 * @since       0.0.1
 */
abstract class NyccEventsHelperUtils {

  /**
   * Method to return the object name being modeled by removing the prefix
   * from the class name.  Return is mangled to all lowercase.
   *
   * @return string
   *
   * @since 0.0.1
   */
  public static function getObjectType($obj) {
    $match = array();
    if (!preg_match('/NyccEvents([A-Z][a-z]+)([A-Z].+)/', get_class($obj), $match)) {
      return false;
    }
    return (object) [ 'type'=>strtolower($match[1]), 'name'=>strtolower($match[2]) ];
  }


}