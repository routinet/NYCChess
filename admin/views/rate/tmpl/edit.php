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

?>
<form action="<?php echo JRoute::_('index.php?option=com_nyccevents&layout=edit&id=' . (int) $this->item->id); ?>"
      method="post" name="adminForm" id="adminForm">
  <div class="form-horizontal">
    <fieldset class="adminform">
      <legend>Rate Details</legend>
      <div class="row-fluid">
        <div class="span6">
          <?php foreach ($this->form->getFieldset() as $field) { ?>
            <div class="control-group">
              <div class="control-label"><?php echo $field->label; ?></div>
              <div class="controls"><?php echo $field->input; ?></div>
            </div>
          <?php } ?>
        </div>
      </div>
    </fieldset>
  </div>
  <input type="hidden" name="task" value="rate.edit" />
  <?php echo JHtml::_('form.token'); ?>
</form>