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
 * NyccEvents Model
 *
 * @since  0.0.1
 */
class NyccEventsModelLanding extends JModelItem
{
  /**
   * @var string message
   */
  protected $message;

  /**
   * Get the message
   *
   * @return  string  The message to be displayed to the user
   */
  public function getMsg()
  {
    if (!isset($this->message))
    {
      $this->message = 'NYCC Events Landing model';
    }

    return $this->message;
  }
}