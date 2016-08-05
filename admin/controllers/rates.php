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
 * Rates Controller
 *
 * @since  0.0.1
 */
class NyccEventsControllerRates extends JControllerAdmin {
  /**
   * Proxy for getModel.
   *
   * @param   string  $name    The model name. Optional.
   * @param   string  $prefix  The class prefix. Optional.
   * @param   array   $config  Configuration array for model. Optional.
   *
   * @return  object  The model.
   *
   * @since   1.6
   */
  public function getModel($name = 'Rate', $prefix = 'NyccEventsModel', $config = array('ignore_request' => true))
  {
    $model = parent::getModel($name, $prefix, $config);

    return $model;
  }
}