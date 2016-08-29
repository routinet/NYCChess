<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */

// No direct access
defined('_JEXEC') or die('Restricted access');
$save_route = JRoute::_('index.php?option=com_nyccevents&id=' . (int) $this->item->id);
?>
<div class="form-horizontal">
  <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
  <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('Event Info')); ?>
  <div class="row-fluid">
    <form method="post" name="adminForm" id="adminForm" action="<?php echo $save_route; ?>">
      <div class="span9">
        <?php echo $this->form->renderFieldset('general'); ?>
      </div>
      <input type="hidden" name="task" value="event.edit" />
      <?php echo JHtml::_('form.token'); ?>
    </form>
  </div>
  <?php echo JHtml::_('bootstrap.endTab'); ?>
  <?php if ((int) $this->item->id) { ?>
  <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'venues', JText::_('Venues')); ?>
  <div class="row-fluid">
    <form method="post" name="adminFormVenues" id="adminFormVenues" action="<?php echo $save_route; ?>">
      <?php echo $this->form->renderField('id'); ?>
      <div class="span9">
        <?php echo $this->form->renderFieldset('add_venues'); ?>
      </div>
      <input type="hidden" name="task" value="event.addVenue" />
      <?php echo JHtml::_('form.token'); ?>
    </form>
    <div class="span9 current-venues">
      <?php
      if (count($this->item->venues)) {
        foreach ($this->item->venues as $venue)
        {
      ?>
      <div class="row-fluid venue-record venue-record-header">
        <div class="span3">Location Name</div>
        <div class="span3">Date of Event</div>
        <div class="span6">Applied Rates</div>
      </div>
      <div class="row-fluid venue-record">
        <div class="span3"><?php echo $venue->location_name; ?></div>
        <div class="span3"><?php echo date("Y-m-d", $venue->event_date); ?></div>
        <div class="span6"><?php
          $these_rates = array_map(function($v){return $v->rate_label;}, $venue->rates);
          sort($these_rates);
          echo implode(',', $these_rates);
          ?></div>
      </div>
      <?php
        }
      } else {
        echo "No venues have been added yet.";
      }
      ?>
    </div>
  </div>
  <?php echo JHtml::_('bootstrap.endTab'); ?>
  <?php } ?>
  <?php echo JHtml::_('bootstrap.endTabSet'); ?>

</div>
