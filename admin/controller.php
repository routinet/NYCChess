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
 * NYCC Events Component Controller
 *
 * @since  0.0.1
 */
class NyccEventsController extends JControllerLegacy {
  protected $default_view = 'menu';
  
  public function __construct(array $config) {
    parent::__construct($config);
    $this->name = 'NyccEvents';
  }
}