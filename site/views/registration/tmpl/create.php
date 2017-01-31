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

$doc = JFactory::getDocument();

?>
<h1>Register for an Event</h1>
</p>
<pre><?php echo var_export($this->venue,1); ?></pre>
<h1>Event</h1>
<pre><?php echo var_export($this->event,1); ?></pre>
<h1>Location</h1>
<pre><?php echo var_export($this->location,1); ?></pre>
