<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * General helper class
 *
 * @since       0.0.1
 */
abstract class NyccEventsHelperUtils {

  /**
   * Method to return the object name being modeled by removing the prefix
   * from the class name.  Return is an object with 'type' and 'name'
   * properties, with both values mangled to all lowercase.
   *
   * @param  object $obj
   *
   * @return mixed
   *         Return will be an object, or false if pattern matching fails.
   *
   * @since 0.0.1
   */
  public static function getObjectType($obj) {
    $match = array();
    if (!preg_match('/NyccEvents([A-Z][a-z]+)([A-Z].+)/', get_class($obj), $match)) {
      return false;
    }
    return (object) [ 'type'=>strtolower($match[1]), 'name'=>strtolower($match[2]) ];
  }

  /**
   * Adds a series of conditions to the model's query.  The $conditions
   * parameter should be formatted like $this->filter_fields.
   *
   * @param JDatabaseQuery $query
   * @param array          $conditions
   *
   * @return JDatabaseQuery
   *
   * @since 0.0.1
   */
  public static function addFilterConditions(JDatabaseQuery $query, Array $conditions) {
    foreach ($conditions as $key=>$val) {
      $query = static::addCondition($query, 'main.' . $key, $val);
    }
    return $query;
  }

  /**
   * Adds a single condition to a query object.
   * TODO: stress-test against various filter settings
   *
   * @param JDatabaseQuery $query
   *        A query object
   * @param string         $field
   *        The field for the condition
   * @param mixed          $value
   *        Can be a NULL, single value, or an array of values
   * @param string         $operator
   *        Desired operator, e.g., '=', '<', etc.  If NULL, it is
   *        auto-detected according to the $value parameter, defaulting
   *        to '=' for a single value, 'IS NULL' for a NULL, or
   *        'IN' for an array.
   * @param string         $glue
   *        The logical join used for this condition, e.g., 'AND', 'OR'.
   *
   * @return JDatabaseQuery
   *
   * @since 0.0.1
   */
  public static function addCondition(JDatabaseQuery $query, $field,
    $value = NULL, $operator = NULL, $glue = 'AND')
  {

    // detect the operator, if necessary
    if (!isset($operator)) {
      switch(true) {
        case is_array($value): $operator = 'IN'; break;
        case !isset($value): $operator = 'IS NULL'; break;
        default: $operator = '=';
      }
    }

    // verify array status with 'IN' operator
    if ($operator === 'IN' && !is_array($value)) {
      $value = array((string) $value);
    }

    // build the value, based on operator settings
    switch ($operator) {
      case 'IN':
        $clause_value = "('" .
          implode("','",
            array_map(function ($v) use ($query) { return $query->e($v); }, $value)
          ) .
          "')";
        break;
      case 'IS NULL':
        $clause_value = "";
        break;
      default:
        $clause_value = is_numeric($value) ? (string) $value : "'" . (string) $value . "'";
        break;
    }

    // build the condition
    $condition = '';
    $field_parts = explode('.', $field);
    if (count($field_parts) > 1) {
      $condition = '`' . array_shift($field_parts) . '`.';
    }
    $condition .= '`' . $query->e((string) $field_parts[0]) . '` '
      . $operator . ($clause_value ? " $clause_value" : '');

    return $query->where($condition, $glue);
  }

  /**
   * Wrapper function to quickly add a message to the application queue.
   *
   * @param string $msg
   * @param string $lvl
   *
   * @since 0.0.1
   */
  public static function setAppError($msg, $lvl = 'error') {
    JFactory::getApplication()->enqueueMessage((string) $msg, (string) $lvl);
  }

}