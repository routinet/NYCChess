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
JHtml::_('jquery.framework');
JHtml::_('script', 'system/html5fallback.js', false, true);

// Make sure jQuery is loaded.
JHtml::_('jquery.framework');


// Add the multiselect style sheet and script files.
$doc = JFactory::getDocument();
$doc->addStyleSheet('/media/' . basename(JPATH_COMPONENT) . '/css/multiselect.css');
$doc->addScript('/media/' . basename(JPATH_COMPONENT) . '/js/multiselect.js');

/**
 * The format of the input tag to be filled in using sprintf.
 *     %1 - id
 *     %2 - name
 *     %3 - value
 *     %4 = any other attributes
 *     %5 = label text
 */
$format = '<input type="checkbox" id="%1$s" name="%2$s" value="%3$s" %4$s /><label for="%1$s">%5$s</label>';
?>
<div class="multiselect-container">
  <div class="multiselect-label"><?php echo $input['label']; ?></div>

  <div id="<?php echo $input['id']; ?>" class="nycc-multiselect <?php echo trim($input['class']); ?>">
		<div class="multiselect-value"></div>
		<div class="multiselect-options">
			<?php
			foreach ($input['options'] as $i => $option) {
				// Initialize some option attributes.
				// TODO: works for a new venue right now.  Make this work for editing a venue (existing checkboxes)
				//$checked = in_array((string) $option->value, $checkedOptions) ? 'checked' : '';
				$checked = '';

				// In case there is no stored value, use the option's default state.
				$optionClass = !empty($option->class) ? 'class="' . $option->class . '"' : '';
				$disabled    = !empty($option->disable) || $input['disabled'] ? 'disabled' : '';

				// Initialize some JavaScript option attributes.
				$onclick  = !empty($option->onclick) ? 'onclick="' . $option->onclick . '"' : '';
				$onchange = !empty($option->onchange) ? 'onchange="' . $option->onchange . '"' : '';

				$oid        = $input['id'] . $i;
				$value      = htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8');
				$attributes = array_filter(array($checked, $optionClass, $disabled, $onchange, $onclick));

				echo '<div class="multiselect-option">' .
					sprintf($format, $oid, $input['name'], $value, implode(' ', $attributes), $option->text) .
					'</div>';
			}
			?>
		</div>
  </div>
</div>
