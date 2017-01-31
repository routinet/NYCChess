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
 * User Model
 *
 * @since  0.0.1
 */
class NyccEventsModelUser extends NyccEventsModelBase {

    public function loadByJoomlaId($id = 0) {
        // Get the table and load the item.
        $table = $this->getTable();
        if (!empty($id)) {
            $table->load(array('joomla_id' => $id));
        }

        // Return a standard object.
        $item = static::translateTableToObject($table);

        return $item;
    }
}