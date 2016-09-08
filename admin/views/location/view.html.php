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
 * Location View
 *
 * @since  0.0.1
 */
class NyccEventsViewLocation extends JViewLegacy {
  /**
   * View form
   *
   * @since  0.0.1
   */
  protected $form = null;

  /**
   * Display the Location view
   *
   * @since  0.0.1
   * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
   *
   * @return  void
   */
  public function display($tpl = null) {
    // Get the Data
    $this->form = $this->get('Form');
    $this->item = $this->get('Item');

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
    JToolBarHelper::title($title, 'Location');
    JToolBarHelper::apply('location.apply', 'JTOOLBAR_APPLY');
    JToolBarHelper::cancel('location.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
  }
}