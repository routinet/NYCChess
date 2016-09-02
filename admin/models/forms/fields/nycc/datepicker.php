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
 * @since  0.0.1
 */
class JFormFieldNYCC_Datepicker extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
	public $type = 'Datepicker';

  /**
   * Name of the layout being used to render the field
   *
   * @var    string
   * @since  0.0.1
   */
  protected $layout = 'datepicker';
  protected $renderLayout = 'datepicker';

  /**
   * Method to get the field input markup.
   *
   * @return  string  The field input markup.
   *
   * @since   0.0.1
   */
  protected function getInput() {

    if (empty($this->layout))
    {
      throw new UnexpectedValueException(sprintf('%s has no layout assigned.', $this->name));
    }

    return $this->getLayoutData();
  }

  /**
   * Method to get the data to be passed to the layout for rendering.
   * Extended to add 'options' element.
   *
   * @return  array
   *
   * @since 0.0.1
   */
  protected function getLayoutData() {
    // Call the parent, then populate additional variables.
    $ret = parent::getLayoutData();

    return $ret;
  }
}
