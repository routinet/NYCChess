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
    protected $form = NULL;

    /**
     * Display the Event view
     *
     * @since  0.0.1
     *
     * @param   string $tpl The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = NULL) {
        $this->item = new NyccEventsObjEvent(JFactory::getApplication()->input->get('id'));
        $this->item->loadPrimaryLocation();
        $this->all_locations  = $this->item->getVenueLocations();
        $this->venues_by_rate = $this->item->getVenuesByRate();
        $this->all_rates      = $this->item->getVenueRateLabels();

        // Display the template
        parent::display($tpl);
    }

}