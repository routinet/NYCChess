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
 * Menu View
 *
 * @since  0.0.1
 */
class NyccEventsViewMenu extends JViewLegacy {
  /**
   * Display the default menu view
   *
   * @param   string  $tpl  The name of the template file to parse
   * @since   0.0.1
   * @return  void
   *
   */
  public function display($tpl = null) {
    // Get the link to config for this component.
    $this->config_url = 'index.php?option=com_config&amp;view=component&amp;component='
      . JFactory::getApplication()->input->get('option');

    // Display the template
    parent::display($tpl);
  }
}