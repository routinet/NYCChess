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
 * Locations View
 *
 * @since  0.0.1
 */
class NyccEventsViewRates extends JViewLegacy {
  /**
   * Display the default menu view
   *
   * @param   string  $tpl  The name of the template file to parse
   * @since   0.0.1
   * @return  void
   *
   */
  function display($tpl = null) {
    // Get data from the model
    $this->items		= $this->get('Items');
    $this->pagination	= $this->get('Pagination');

    // Check for errors.
    if (count($errors = $this->get('Errors')))
    {
      JError::raiseError(500, implode('<br />', $errors));

      return;
    }

    // Add the toolbar.
    $this->addToolBar();

    // Display the template
    parent::display($tpl);
  }

  /**
   * Add the page title and toolbar.
   *
   * @return  void
   *
   * @since   1.6
   */
  protected function addToolBar() {
    JToolBarHelper::title('NYCC Events Rates');
    JToolBarHelper::addNew('rate.add');
    JToolBarHelper::editList('rate.edit');
    JToolBarHelper::deleteList('', 'rates.delete');
  }
}