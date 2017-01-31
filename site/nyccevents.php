<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */

// TODO: make sure index.html is in every directory

// TODO: make sure this line is in every file
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Do component bootstrap.
require_once 'init.php';

// Get an instance of the controller
$controller = JControllerLegacy::getInstance('NyccEvents');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();