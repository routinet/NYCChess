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

// Make sure jQuery is loaded.
JHtml::_('jquery.framework');

// Register the search path for objects
JLoader::registerPrefix('NyccEventsHelper', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');
JLoader::registerPrefix('NyccEventsModel', JPATH_COMPONENT . '/models');
JLoader::registerPrefix('NyccEventsTable', JPATH_COMPONENT_ADMINISTRATOR . '/tables');
JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
JForm::addFieldPath(JPATH_COMPONENT . '/models/forms/fields');

/*JFactory::getDocument()->addScript('/media/' . basename(JPATH_COMPONENT) . '/js/nycc-base.js');
JFactory::getDocument()->addStyleSheet('/media/' . basename(JPATH_COMPONENT) . '/css/nycc-base.css');
*/

// Get an instance of the controller
$controller = JControllerLegacy::getInstance('NyccEvents');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();