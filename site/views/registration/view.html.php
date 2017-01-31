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
 * Site Registration View
 *
 * @since  0.0.1
 */
class NyccEventsViewRegistration extends JViewLegacy {
    /**
     * Display the Registration view
     *
     * @since  0.0.1
     *
     * @param   string $tpl The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = NULL) {
        logit("display registration view with template $tpl");

        // Prepare the layout veriables.
        if (!$this->prepareLayout()) {
            $layout = JFactory::getApplication()->input->get('layout', 'default', 'string');
            throw new Exception(JText::_("Could not prepare layout '$layout'."), 500);
        }

        // Display the template
        parent::display($tpl);
    }

    /**
     * Wrapper function to prepare the variables for this view based on
     * the requested layout.
     *
     * @return bool
     *
     * @since 0.0.1
     */
    public function prepareLayout() {
        // Initialize the return.
        $ret = FALSE;

        // Get the layout name from the request.
        $layout = ucfirst(
            JFactory::getApplication()->input->get('layout', 'default', 'string')
        );

        // Prepare variables based on the layout name.
        if ($callback = method_exists($this, "prepareLayout$layout")) {
            $ret = $this->$callback();
        }

        // If a venue was loaded, load the associated event and location.
        if ($ret && isset($this->venue->id)) {
            // Load the associated event (no children).
            $this->event = new NyccEventsObjEvent($this->venue->event_id, array('load_children' => FALSE));

            // Load the location.
            $this->location = new NyccEventsObjLocation($this->venue->location_id);
        }

        return $ret;
    }

    /**
     * Prepares the variables for the "create" layout.
     *
     * @return bool
     *
     * @since 0.0.1
     */
    public function prepareLayoutCreate() {
        // Get the application and session references.
        $app = JFactory::getApplication();

        // The venue_id may be populated in different ways for different layouts.
        $venue_id = $app->input->get('register_venue', NULL, 'int');

        // Get any venue IDs posted to the request.
        if (!is_array($venue_id)) {
            $venue_id = $venue_id ? array($venue_id) : array();
        }
        logit("Posted venue_id=\n" . var_export($venue_id, 1));

        // Add any venue IDs still pending registration.
        $session_venues = $app->getUserState('registration.venue_id', array());
        $venue_id       = array_merge($session_venues, $venue_id);
        logit("Final found venues=\n" . var_export($venue_id, 1));

        // If no venues have been selected, return to the referer.
        if (!count($venue_id)) {
            NyccEventsHelperUtils::setAppError('Please select a venue before continuing.');
            $app->redirect($_SERVER['HTTP_REFERER']);

            return FALSE;
        }

        // Load the venue with all children.
        $this->venue = new NyccEventsObjVenue($venue_id[0]);
        if ($this->venue->id != $venue_id[0]) {
            NyccEventsHelperUtils::setAppError("We encountered an error while retrieving this venue.  Please contact the site administrator.");
            $app->redirect('/');

            return FALSE;
        }

        // Prepare the form data.
        $data = array();

        // Initialize the form for creating a venue
        $this->venue_form = JForm::getInstance(
            'com_nyccevents.registration_create',
            'registration_create',
            'regcreate'
        );

        // JModelForm->preprocessData() would be called here, but we inherited
        // from JModelLegacy to remove cruft.  This can be changed later if
        // plugin functionality is desired.

        // Save the list of pending venues.
        $app->setUserState('registration.venue_id', $venue_id);

        return TRUE;
    }
}