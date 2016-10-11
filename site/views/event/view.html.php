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
 * Site Event View
 *
 * @since  0.0.1
 */
class NyccEventsViewEvent extends JViewLegacy {
  /**
   * View form
   *
   * @since  0.0.1
   */
  protected $form = null;

  /**
   * Display the Event view
   *
   * @since  0.0.1
   * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
   *
   * @return  void
   */
  public function display($tpl = null) {
    // Get the Data and load it into the form
    $this->item = (object) ['data'=>$this->get('Item')];

    // Get the details of the primary location
    $this->item->location = JModelLegacy::getInstance('location', 'NyccEventsModel')
      ->getItem($this->item->data->main_location);

    // Display the template
    parent::display($tpl);
  }

}