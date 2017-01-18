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
 * Venue Rates List Model
 *
 * @since  0.0.1
 */
class NyccEventsModelVenueRates extends NyccEventsModelBaseList {
  protected $_table_name = 'venue_rates';

    protected $_lookups = array(
        'venue' => array('field'=>'venue_id', 'table'=>'venues', 'lookup'=>'display_name'),
        'rate' => array('field'=>'rate_id', 'table'=>'rates', 'lookup'=>'label'),
    );

    /**
     * Override in child to modify the query object
     *
     * @param JDatabaseQuery object
     * @since 0.0.1
     */
    protected function addQueryRelations(&$query) {
        $query->join('INNER',"#__nycc_venues venues on venues.id=main.venue_id AND venues.active=1")
            ->join('INNER',"#__nycc_rates rates on rates.id=main.rate_id AND rates.active=1")
            ->select(array("venues.display_name as venue_name","rates.label as rate_label"));
    }

}