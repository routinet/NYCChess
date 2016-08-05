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

/**
 * Location Table class
 *
 * @since  0.0.1
 */
class NyccEventsTableBaseTable extends JTable {

  /**
   * @var string
   * @since 0.0.1
   */
  protected $_table_name = '';

  /**
   * An array of fields, e.g. `active`, which are boolean fields presented
   * as field type "checkbox".  The default table class does not properly
   * handle setting a false state.
   *
   * @see NyccEventsTableBaseTable->_convertBoolIntFields()
   * @var array
   * @since 0.0.1
   */
  public $boolint_fields = array();

  /**
   * Constructor
   *
   * @since   0.0.1
   * @throws  RuntimeException
   * @param   JDatabaseDriver  &$db  A database connector object
   */
  function __construct(&$db) {
    if (!$this->_table_name) {
      throw new RuntimeException(get_called_class() . " failed to identify its table");
    }
    parent::__construct("#__nycc_{$this->_table_name}", 'id', $db);
    $this->setColumnAlias('published','active');
  }

  /**
   * Takes submitted form data and sets missing checkbox fields to zero.
   * This is necessary because the JTable does not properly detect
   * missing checkbox fields, i.e., checkboxes left unchecked.
   *
   * @param $src
   *
   * @return mixed
   *
   * @since version
   */
  private function _convertBoolIntFields($src) {
    foreach ($this->boolint_fields as $val) {
      if (!array_key_exists($val, $src)) {
        $src[$val] = 0;
      }
    }
    return $src;
  }

  /**
   * @param  array|object $src
   * @param  array        $ignore
   *
   * @return bool
   *
   * @since  0.0.1
   */
  public function bind($src, $ignore = array()){
    return parent::bind($this->_convertBoolIntFields($src), $ignore);
  }
}