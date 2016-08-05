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

// Register the search path for objects
JLoader::registerPrefix('NyccEventsHelper', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');
JLoader::registerPrefix('NyccEventsModel', JPATH_COMPONENT_ADMINISTRATOR . '/models');
JLoader::registerPrefix('NyccEventsTable', JPATH_COMPONENT_ADMINISTRATOR . '/tables');

// Get an instance of the controller
$controller = JControllerLegacy::getInstance('NyccEvents');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();