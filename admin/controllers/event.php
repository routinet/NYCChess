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
 * Event Controller
 *
 * @since       0.0.1
 */
class NyccEventsControllerEvent extends JControllerForm {
  public function addVenue() {
    $model = $this->getModel();
    $event = $model->getItem($this->input->get('id'));
  }
}