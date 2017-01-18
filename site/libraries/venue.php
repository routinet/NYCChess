<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 * @since       0.0.1
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */
class NyccEventsObjVenue extends NyccEventsObjBase {

    protected $_children = array(
        'rates' => array(
            'list_model' => 'Venuerates',
            'item_model' => 'Venuerate',
            'fk'         => 'venue_id'
        ),
    );

    public function getRateLabels($refresh = FALSE) {
        $cached = $this->_get_cache('rate_labels');

        if (is_null($cached) || $refresh) {
            $cached = array();
            if (is_array($this->_child_data['rates'])) {
                foreach ($this->_child_data['rates'] as $k1 => $rate) {
                    $cached[$rate->rate_id] = $rate->rate_label;
                }
            }
            asort($cached);
            $this->_set_cache($cached, 'rate_labels');
        }

        return $cached;
    }
}