<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */


defined('JPATH_PLATFORM') or die;

/**
 * Supports an custom SQL select list
 *
 * @since  11.1
 */
class JFormFieldMultiselect extends JFormFieldSQL
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
	public $type = 'Multiselect';

  /**
   * Name of the layout being used to render the field
   *
   * @var    string
   * @since  0.0.1
   */
  protected $layout = 'multiselect';

  /**
   * Method to get the field input markup.
   *
   * @return  string  The field input markup.
   *
   * @since   0.0.1
   */
  protected function getInput()
  {
    if (empty($this->layout))
    {
      throw new UnexpectedValueException(sprintf('%s has no layout assigned.', $this->name));
    }

    return $this->getRenderer($this->layout)->render($this->getLayoutData());
  }

  /**
   * Method to get the data to be passed to the layout for rendering.
   *
   * @return  array
   *
   * @since 0.0.1
   */
  protected function getLayoutData() {
    // Label preprocess
    $label = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];
    $label = $this->translateLabel ? JText::_($label) : $label;

    // Description preprocess
    $description = !empty($this->description) ? $this->description : null;
    $description = !empty($description) && $this->translateDescription ? JText::_($description) : $description;

    $alt = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname);

    return array(
      'autocomplete' => $this->autocomplete,
      'autofocus'    => $this->autofocus,
      'class'        => $this->class,
      'description'  => $description,
      'disabled'     => $this->disabled,
      'field'        => $this,
      'group'        => $this->group,
      'hidden'       => $this->hidden,
      'hint'         => $this->translateHint ? JText::alt($this->hint, $alt) : $this->hint,
      'id'           => $this->id,
      'label'        => $label,
      'labelclass'   => $this->labelclass,
      'multiple'     => $this->multiple,
      'name'         => $this->name,
      'onchange'     => $this->onchange,
      'onclick'      => $this->onclick,
      'options'      => $this->getOptions(),
      'pattern'      => $this->pattern,
      'readonly'     => $this->readonly,
      'repeat'       => $this->repeat,
      'required'     => (bool) $this->required,
      'size'         => $this->size,
      'spellcheck'   => $this->spellcheck,
      'validate'     => $this->validate,
      'value'        => $this->value
    );
  }
}
