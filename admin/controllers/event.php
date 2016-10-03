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
  public function addVenues() {
    // initialize the dbo, model, and table
    $dbo = JFactory::getDbo();
    $venue_model = new NyccEventsModelVenue();

    // set up the initial values.  need id=0 to make a new record
    $id = $this->input->get('id', 'INT');
    $bind_array = array(
      'event_id' => $id,
      'event_date' => time(),
      'id' => 0,
      'active' => 1
    );

    // get the form data
    $new_locs = $this->input->get('venue_location', array(), 'ARRAY');
    $new_rates = $this->input->get('venue_rates', array(), 'ARRAY');

    // the datepicker field submits as a comma-delimited list of dates.
    $new_dates = $this->input->get('venue_dates', '', 'STRING');
    $new_dates = $new_dates == '' ? array() : explode(',', $new_dates);
    foreach ($new_dates as $k=>$v) {
      $new_dates[$k] = strtotime($v);
    }

    // seed the success
    $success = count($new_locs) && count($new_dates);

    // for each location, for each day, add one record
    foreach ($new_locs as $key=>$val) {
      foreach ($new_dates as $key2=>$val2) {
        // set the location and date
        $bind_array['location_id'] = $val;
        $bind_array['event_date'] = $val2;

        // Add the venue
        $success &= $venue_model->addFullVenue($bind_array, $new_rates);

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
      $msg = "An error occurred while saving the venue(s).";
      if (!(count($new_locs) && count($new_dates))) {
        $msg .= " (Locations or Dates was blank)";
      }
      NyccEventsHelperUtils::setAppError($msg);
    }

    // redirect back to the form
    $uri = '/administrator/index.php?option=com_nyccevents&view=event&id=' .
      $id . $this->getRedirectToItemAppend() . '#venues';
    $this->setRedirect($uri);
  }
}