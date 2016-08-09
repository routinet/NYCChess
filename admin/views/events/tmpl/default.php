<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */


// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<h2><?php echo ucfirst($this->getName()); ?></h2>
<form action="index.php?option=com_nyccevents&view=events" method="post" id="adminForm" name="adminForm">
  <table class="table table-striped table-hover">
    <thead>
    <tr>
      <th width="1%">##</th>
      <th width="2%"><?php echo JHtml::_('grid.checkall'); ?></th>
      <th width="90%">Name</th>
      <th width="5%">Active</th>
      <th width="2%">ID</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
      <td colspan="5">
        <?php echo $this->pagination->getListFooter(); ?>
      </td>
    </tr>
    </tfoot>
    <tbody>
      <?php foreach ($this->items as $i => $row) { ?>
      <tr>
        <td>
          <?php echo $this->pagination->getRowOffset($i); ?>
        </td>
        <td>
          <?php echo JHtml::_('grid.id', $i, $row->id); ?>
        </td>
        <td>
          <?php
          $link = JRoute::_('index.php?option=com_nyccevents&task=event.edit&id=' . $row->id);
          echo "<a href=\"{$link}\" title=\"Edit\">{$row->name}</a>";
          ?>
        </td>
        <td align="center">
          <?php echo JHtml::_('jgrid.published', $row->active, $i, 'events.', true, 'cb'); ?>
        </td>
        <td align="center">
          <?php echo $row->id; ?>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="boxchecked" value="0" />
  <?php echo JHtml::_('form.token'); ?>
</form>