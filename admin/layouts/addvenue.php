<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */

defined('JPATH_BASE') or die;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string   $autocomplete    Autocomplete attribute for the field.
 * @var   boolean  $autofocus       Is autofocus enabled?
 * @var   string   $class           Classes for the input.
 * @var   string   $description     Description of the field.
 * @var   boolean  $disabled        Is this field disabled?
 * @var   string   $group           Group the field belongs to. <fields> section in form XML.
 * @var   boolean  $hidden          Is this field hidden in the form?
 * @var   string   $hint            Placeholder for the field.
 * @var   string   $id              DOM id of the field.
 * @var   string   $label           Label of the field.
 * @var   string   $labelclass      Classes to apply to the label.
 * @var   boolean  $multiple        Does this field support multiple values?
 * @var   string   $name            Name of the input field.
 * @var   string   $onchange        Onchange attribute for the field.
 * @var   string   $onclick         Onclick attribute for the field.
 * @var   string   $pattern         Pattern (Reg Ex) of value of the form field.
 * @var   boolean  $readonly        Is this field read only?
 * @var   boolean  $repeat          Allows extensions to duplicate elements.
 * @var   boolean  $required        Is this field required?
 * @var   integer  $size            Size attribute of the input.
 * @var   boolean  $spellcheck      Spellcheck state for the form field.
 * @var   string   $validate        Validation rules to apply.
 * @var   string   $value           Value attribute of the field.
 * @var   array    $checkedOptions  Options that will be set as checked.
 * @var   boolean  $hasValue        Has this field a value assigned?
 * @var   array    $options         Options available for this field.
 */

// Including fallback code for HTML5 non supported browsers.
JHtml::_('script', 'system/html5fallback.js', false, true);

// Add the multiselect style sheet and script files.
$doc = JFactory::getDocument();
$doc->addScript('/media/' . basename(JPATH_COMPONENT) . '/js/ajax-handler.js');
?>
<fieldset id="<?php echo $id; ?>" class="nycc-add-venue <?php echo trim($class); ?>">
  <div class="row-fluid">
    <div class="span4"><?php echo $subform->renderField('venue_location'); ?></div>
    <div class="span3"><?php echo $subform->renderField('venue_dates'); ?></div>
    <div class="span4"><?php echo $subform->renderField('venue_rates'); ?></div>
  </div>
  <div class="nycc-add-venue-submit"><input type="submit" value="Save New Venue" /></div>
</fieldset>
