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
$this_route = JRoute::_('index.php?option=com_nyccevents&layout=edit&id=' . (int) $this->item->id);
?>
<form method="post" name="adminForm" id="adminForm" action="<?php echo $this_route; ?>">
  <div class="form-horizontal">
    <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('Event Info')); ?>
    <div class="row-fluid">
      <div class="span9">
        <?php echo $this->form->renderFieldset('general'); ?>
      </div>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>
    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'venues', JText::_('Venues')); ?>
    <div class="row-fluid">
      <div class="span9">
        <?php echo $this->form->renderFieldset('venues'); ?>
      </div>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>
    <?php echo JHtml::_('bootstrap.endTabSet'); ?>

    <input type="hidden" name="task" value="event.edit" />
    <?php echo JHtml::_('form.token'); ?>
  </div>
</form>
