<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 * @since       0.0.1
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Constants for custom objects
define('NYCCEVENTS_LOAD_CHILDREN', 1);
define('NYCCEVENTS_LOAD_RECURSIVE', 2);

// Make sure jQuery is loaded.
JHtml::_('jquery.framework');

// Register the search path for objects
JLoader::registerPrefix('NyccEventsObj', JPATH_COMPONENT . '/libraries');
JLoader::registerPrefix('NyccEventsHelper', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');
JLoader::registerPrefix('NyccEventsModel', JPATH_COMPONENT . '/models');
JLoader::registerPrefix('NyccEventsTable', JPATH_COMPONENT_ADMINISTRATOR . '/tables');
JForm::addFormPath(JPATH_COMPONENT . '/models/forms');
JForm::addFieldPath(JPATH_COMPONENT . '/models/forms/fields');

//JFactory::getDocument()->addScript('/media/' . basename(JPATH_COMPONENT) . '/js/nycc-base.js');
JFactory::getDocument()
    ->addStyleSheet('/media/' . basename(JPATH_COMPONENT) . '/css/nycc-base.css');

// Initialize the component user object
global $NYCCUser;
$NYCCUser = new NyccEventsObjUser(NULL, array('use_joomla_id' => TRUE));
logit("Loaded User=\n".var_export($NYCCUser,1));