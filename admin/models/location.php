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
 * Location Model
 *
 * @since  0.0.1
 */
class NyccEventsModelLocation extends JModelAdmin {
  /**
   * Method to get a table object, load it if necessary.
   *
   * @param   string  $type    The table name. Optional.
   * @param   string  $prefix  The class prefix. Optional.
   * @param   array   $config  Configuration array for model. Optional.
   *
   * @return  JTable  A JTable object
   *
   * @since   0.0.1
   */
  public function getTable($type = 'Location', $prefix = 'NyccEventsTable', $config = array()) {
    return JTable::getInstance($type, $prefix, $config);
  }

  /**
   * Method to get the record form.
   *
   * @param   array    $data      Data for the form.
   * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
   *
   * @return  mixed    A JForm object on success, false on failure
   *
   * @since   0.0.1
   */
  public function getForm($data = array(), $loadData = true) {
    // Get the form.
    $form = $this->loadForm(
      'com_nyccevents.location',
      'location',
      array(
        'control' => 'jform',
        'load_data' => $loadData
      )
    );

    if (empty($form)) {
      return false;
    }

    return $form;
  }

  /**
   * Method to get the data that should be injected in the form.
   *
   * @return  mixed  The data for the form.
   *
   * @since   0.0.1
   */
  protected function loadFormData() {
    // Check the session for previously entered form data.
    $data = JFactory::getApplication()->getUserState(
      'com_nyccevents.edit.location.data',
      array()
    );

    if (empty($data)) {
      $data = $this->getItem();
    }

    return $data;
  }
}