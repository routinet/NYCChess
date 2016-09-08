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
 * Events View
 *
 * @since  0.0.1
 */
class NyccEventsViewEvents extends JViewLegacy {
  /**
   * Display the default menu view
   *
   * @param   string  $tpl  The name of the template file to parse
   * @since   0.0.1
   * @return  mixed
   *
   */
  function display($tpl = null) {

    // Get the application
    $app = JFactory::getApplication();

    // Verify location/rate record dependencies are met
    $locations = new NyccEventsModelLocations(array('filter_fields' => array('active' => 1)));
    if ((int) $locations->getTotal() < 1) {
      $link = '<a href="/administrator/index.php?option=com_nyccevents&view=locations">Manage Locations</a>';
      // TODO: build these links properly
      $app->enqueueMessage("You must have at least one active location before managing events. $link", 'warning');
    }
    $rates = new NyccEventsModelRates(array('filter_fields' => array('active' => 1)));
    if ((int) $rates->getTotal() < 1) {
      // TODO: build these links properly
      $link = '<a href="/administrator/index.php?option=com_nyccevents&view=rates">Manage Rates</a>';
      $app->enqueueMessage("You must have at least one active rate before managing events. $link", 'warning');
    }

    // Get data from the model
    $this->items		= $this->get('Items');
    $this->pagination	= $this->get('Pagination');

    // Check for errors.
    if (count($errors = $this->get('Errors'))) {
      JError::raiseError(500, implode('<br />', $errors));
      return false;
    }

    // Add the toolbar.
    $this->addToolBar();

    // Display the template
    return parent::display($tpl);
  }

  /**
   * Add the page title and toolbar.
   *
   * @return  void
   *
   * @since   1.6
   */
  protected function addToolBar() {
    JToolBarHelper::title('NYCC Event Manager');
    JToolBarHelper::addNew('event.add');
    JToolBarHelper::editList('event.edit');
    JToolBarHelper::deleteList('', 'events.delete');
  }
}