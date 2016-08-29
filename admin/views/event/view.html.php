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
 * Event View
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
    $this->item = $this->get('Item');
    $this->form = $this->getModel()->getForm($this->item, false);
    logit("item data=".var_export($this->item,1));

    // Set the toolbar
    $this->addToolBar();

    // Display the template
    parent::display($tpl);
  }

  /**
   * Add the page title and toolbar.
   *
   * @return  void
   *
   * @since   0.0.1
   */
  protected function addToolBar() {
    $isNew = ($this->item->id == 0);
    $title = $isNew ? "New" : "Edit";
    JToolBarHelper::title($title, 'Event');
    JToolBarHelper::apply('event.apply', 'Save');
    JToolBarHelper::cancel('event.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
  }
}