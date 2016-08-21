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
class JFormFieldNYCC_Addvenue extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  0.0.1
	 */
	public $type = 'AddVenue';

  /**
   * Name of the layout being used to render the field
   *
   * @var    string
   * @since  0.0.1
   */
  protected $layout = 'addvenue';

  /**
   * JForm object to hold subform controls
   *
   * @var JForm
   * @since 0.0.1
   */
  protected $subform = null;

  /**
   * NYCC-related field objects
   *
   * @var array
   * @since 0.0.1
   */
  public $nycc = null;

  /**
   * Name of the default layout for the Add Venue subform
   *
   * @var string path
   * @since 0.0.1
   */
  protected $subform_layout = 'addvenue_subform';

  /**
   * Method to get the data to be passed to the layout for rendering.
   * Extended to add 'options' element.
   *
   * @return  array
   *
   * @since 0.0.1
   */
  protected function getLayoutData() {
    $ret = parent::getLayoutData();

    $ret['subform'] = $this->subform;

    return $ret;
  }

  /**
   * Method to attach a JForm object to the field.
   *
   * @param   SimpleXMLElement  $element  The SimpleXMLElement object representing the <field /> tag for the form field object.
   * @param   mixed             $value    The form field value to validate.
   * @param   string            $group    The field name group control value.
   *
   * @return  boolean  True on success.
   *
   * @since   0.0.1
   */
  public function setup(SimpleXMLElement $element, $value, $group = null) {

    if (!parent::setup($element, $value, $group)) {
      return false;
    }

    if (!isset($this->nycc) || !is_a($this->nycc, 'JRegistry')) {
      $this->nycc = new JRegistry();
    }

    $this->setSubform();

    return true;
  }

  public function setSubform($xml = null) {
    $this->subform = new JForm('addvenue_subform');
    if (is_string($xml) || is_a($xml, 'SimpleXMLElement')) {
      $this->subform->load($xml);
    } else {
      $this->subform->loadFile(dirname(__FILE__) . '/addvenue_subform.xml');
    }
  }

}
