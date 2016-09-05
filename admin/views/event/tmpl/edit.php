<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */

$doc = JFactory::getDocument();
// Add datatables
$doc->addScript("https://cdn.datatables.net/v/dt/dt-1.10.12/fh-3.1.2/datatables.min.js");
$doc->addScriptDeclaration("jQuery(function(\$) { \$('.nycc-datatable').DataTable(); });");
$doc->addStyleSheet("https://cdn.datatables.net/v/dt/dt-1.10.12/fh-3.1.2/datatables.min.css");

// No direct access
defined('_JEXEC') or die('Restricted access');
$save_route = JRoute::_('index.php?option=com_nyccevents&id=' . (int) $this->item->id);
$hash_tabset = 'myTab';
?>
<div class="form-horizontal">
  <?php echo JHtml::_('bootstrap.startTabSet', $hash_tabset, array('active' => 'general')); ?>
  <?php echo JHtml::_('bootstrap.addTab', $hash_tabset, 'general', JText::_('Event Info')); ?>
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
  <?php echo JHtml::_('bootstrap.addTab', $hash_tabset, 'venues', JText::_('Venues')); ?>
  <div class="row-fluid">
    <form method="post" name="adminFormVenues" id="adminFormVenues" action="<?php echo $save_route; ?>">
      <?php echo $this->form->renderField('id'); ?>
      <?php echo $this->form->renderFieldset('add_venues'); ?>
      <input type="hidden" name="task" value="event.addVenue" />
      <?php echo JHtml::_('form.token'); ?>
    </form>
    <div class="current-venues">
      <table id="current-venues" class="nycc-datatable">
        <thead>
        <tr class="venue-record venue-record-header">
          <td>Location Name</td>
          <td>Date of Event</td>
          <td>Applied Rates</td>
        </tr>
        </thead>
        <tbody>
      <?php
      if (count($this->item->venues)) {
        foreach ($this->item->venues as $venue)
        {
      ?>
          <tr class="venue-record">
            <td><?php echo $venue->location_name; ?></td>
            <td><?php echo date("Y-m-d", $venue->event_date); ?></td>
            <td><?php
                $these_rates = array_map(function($v){return $v->rate_label;}, $venue->rates);
                sort($these_rates);
                echo implode(',', $these_rates);
                ?></td>
          </tr>
      <?php
        }
      } else {
      ?>
          <tr class="venue-record empty-list">
            <td colspan="3">No venues have been added yet.</td>
          </tr>
      <?php
      }
      ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php echo JHtml::_('bootstrap.endTab'); ?>
  <?php } ?>
  <?php echo JHtml::_('bootstrap.endTabSet'); ?>

</div>
<script type="text/javascript">
  (function ($, document, window, undefined) {
    $(document).ready(function () {
      if (window.location.hash) {
        var
          hash_tab = '#<?php echo $hash_tabset; ?>';
          all_tabs = $(hash_tab + 'Tabs'),
          tab = all_tabs.find('a[href="' + window.location.hash + '"]'),
          ct = $(hash_tab + 'Content.tab-content');
        if (tab) {
          all_tabs.find('li.active').removeClass('active');
          tab.closest('li').addClass('active');
          ct.find('.tab-pane.active').removeClass('active');
          ct.find(window.location.hash + '.tab-pane').addClass('active');
        }
      }
    });
  })(jQuery, document, window);
</script>