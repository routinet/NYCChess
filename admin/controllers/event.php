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
  /**
   * Adds a series of venues to an event from the edit form.  Form data will
   * include an array of locations and a date range.  Each location/day is
   * saved as a new venue.
   *
   * @since 0.0.1
   */
  public function addVenue() {
    // initialize the dbo, model, and table
    $dbo = JFactory::getDbo();
    $venue_model = new NyccEventsModelVenue();
    $venue_table = $venue_model->getTable();

    // set up the initial values.  need id=0 to make a new record
    $id = $this->input->get('id', 'INT');
    $bind_array = array(
      'event_id' => $id,
      'event_date' => time(),
      'id' => 0,
      'active' => 1
    );

    // seed the success
    $success = true;

    // get the form data
    $new_locs = $this->input->get('venue_location', array(), 'ARRAY');
    $new_dates = $this->input->get('venue_dates', '', 'STRING');
    $new_dates = $new_dates == '' ? array() : explode(',', $new_dates);
    foreach ($new_dates as $k=>$v) {
      $new_dates[$k] = strtotime($v);
    }
    $new_rates = $this->input->get('venue_rates', array(), 'ARRAY');

    // for each location, for each day, add one record
    foreach ($new_locs as $key=>$val) {
      foreach ($new_dates as $key2=>$val2) {
        // set the location and dat
        $bind_array['location_id'] = $val;
        $bind_array['event_date'] = $val2;
        // save the record
        $success &= $venue_table->save($bind_array);
        if ($success) {
          // save the rates.  Do a mass INSERT to save cycles.
          $query = $dbo->getQuery(TRUE);
          $query->insert('#__nycc_venue_rates')
            ->columns('venue_id,rate_id');
          foreach ($new_rates as $key3=>$val3) {
            $query->values($venue_table->id.','.$val3);
          }
          $dbo->setQuery($query);
          $success &= $dbo->execute();
        }
        // If an error occurred, just leave
        if (!$success) {
          break 2;
        }
      }
    }

    // set the success message
    if ($success) {
      NyccEventsHelperUtils::setAppError("Venue(s) saved.", "success");
    } else {
      NyccEventsHelperUtils::setAppError("An error occurred while saving the venue(s).");
    }

    // redirect back to the form
    $uri = '/administrator/index.php?option=com_nyccevents&view=event&id=' .
      $id . $this->getRedirectToItemAppend() . '#venues';
    $this->setRedirect($uri);
  }
}