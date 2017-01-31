<?php

/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 * @since       0.0.1
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */
class NyccEventsObjUser extends NyccEventsObjBase {

    /**
     * NyccEventsObjUser constructor.
     *
     * @param int   $item_id
     * @param array $config
     *
     * @since 0.0.1
     */
    public function __construct($item_id = NULL, Array $config = array()) {
        parent::__construct(NULL, $config);

        if ($item_id) {
            if (isset($config['use_joomla_id']) && $config['use_joomla_id']) {
                $this->loadByJoomlaId($item_id);
            }
            else {
                $this->load($item_id);
            }
        }
    }

    /**
     * Loads the user object by corresponding Joomla ID
     * @param int $id
     *
     * @since 0.0.1
     */
    public function loadByJoomlaId($id = NULL) {
        // If no ID is passed, use the current user.
        if (!(int)$id) {
            $id = JFactory::getUser()->id;
        }

        // Get the model and load the item.
        $model = $this->getModel();
        $this->load($model->loadByJoomlaId($id));
    }

}