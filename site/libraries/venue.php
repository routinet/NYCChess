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
    'rates' => array('list_model'=>'Venuerates', 'item_model'=>'Venuerate', 'fk'=>'venue_id'),
    );

}