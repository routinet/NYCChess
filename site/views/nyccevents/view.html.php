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
 * HTML View class for the NYCCEvents Component
 *
 * @since  0.0.1
 */
class NyccEventsViewNyccEvents extends JViewLegacy
{

  /**
   * Display the default view
   *
   * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
   *
   * @return  void
   */
  function display($tpl = null)
  {
    // Assign data to the view
    $this->msg = $this->get('Msg');

    // Check for errors.
    if (count($errors = $this->get('Errors')))
    {
      JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

      return;
    }

    // Display the view
    parent::display($tpl);
  }}