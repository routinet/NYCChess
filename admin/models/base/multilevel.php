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
 * A base model for an object which owns subobjects.
 * JModelLegacy -> JModelForm -> ModelAdmin -> NyccEventsModelBaseAdmin
 *
 * Includes functionality to load properties which are lists of other objects.
 * For example, $family->parents will be an array of parent objects.  Handy to
 * load an entire business-logic model.
 *
 * @since 0.0.1
 */
class NyccEventsModelBaseMultilevel extends NyccEventsModelBaseAdmin {

  /**
   * Internal store of subobjects definitions.  Each element in the array is an array of:
   *   'list_model' => name of the Model to use for the list
   *   'item_model' => name of the Model to use for each item
   *   'fk'         => foreign key field
   *   'fk_value'   => for loading, the specific value of the foreign key to search
   * Example: 'venues' => array('list_model'=>'Venues', 'item_model'=>'Venue', 'fk'=>'event_id')
   * The fk and pk fields may be arrays, but must be of the same length.
   * This should be set in the extended __construct()
   *
   * @var array
   * @since 0.0.1
   */
  protected $_joins = array();

  /**
   * Sets a flag indicating if subobjects should be loaded with the item
   * By default, this setting is also propagated to subobjects, meaning the
   * entire tree will be loaded through cascades.
   *
   * @var boolean
   * @since 0.0.1
   */
  public $load_objects = true;

  /**
   * NyccEventsModelBaseList constructor.
   *
   * @param array $config
   * @since 0.0.1
   */
  public function __construct(array $config) {
    parent::__construct($config);

    if (isset($config['load_objects'])) {
      $this->load_objects = (boolean)$config['load_objects'];
    }
  }

  /**
   * Method to get a single record.  Collection object have subobject properties
   *
   * @param   integer  $pk  The id of the primary key.
   *
   * @return  mixed    Object on success, false on failure.
   *
   * @since   0.0.1
   *
   * @see     JModelAdmin
   */
  public function getItem($pk = null) {

    // load the parent item
    $event = parent::getItem($pk);

    // if parent item exists
    if ($this->load_objects && !empty($event->id) && count($this->_joins)) {
      // load each subgroup
      $this->loadAllObjects($event);
    }

    return $event;
  }

  /**
   * @param      $subtable
   *     An array, such as an element of NyccEventsModelBaseMulti->_joins
   * @param bool $load_objects
   *     Indicates if object loading is cascaded.
   *
   * @return array
   *     An array of JObject, such as the return of JModelAdmin->getItem()
   *
   * @since 0.0.1
   */
  public static function loadObject($subtable, $load_objects = true) {

    // initialize the return
    $this_sub = array();

    // set up the filter
    if (empty($subtable['fk']) || empty($subtable['fk_value'])) {
      NyccEventsHelperUtils::setAppError("Subtable was not populated.  See " . __FILE__);
      return $this_sub;
    }

    // set up the model configs (propagate load_objects, set filter, set state)
    $list_config = array('ignore_request' => true,
                         'filter_fields' => array($subtable['fk'] => $subtable['fk_value'])
    );
    $item_config = array('load_objects' => $load_objects);

    // set up the models - one for list, one for item
    $list_model_name = 'NyccEventsModel' . $subtable['list_model'];
    $item_model_name = 'NyccEventsModel' . $subtable['item_model'];

    // instantiate the Models
    try {
      // instantiate
      $list_model = new $list_model_name($list_config);
      $item_model = new $item_model_name($item_config);
    } catch (Exception $e) {
      NyccEventsHelperUtils::setAppError($e->getMessage());
      return $this_sub;
    }

    // set the state limit on the list model (we want all records)
    $list_model->setState('list.limit', 0);

    // propagate the load_objects setting
    $item_model->load_objects = (boolean) $load_objects;

    // iterate through found items, and create objects for them
    foreach ($list_model->getItems($list_config) as $key=>$val) {
      $this_sub[] = $item_model->getItem($val->id);
    }

    return $this_sub;
  }

  /**
   * Loads all subobjects (defined in $this->_joins) for the model
   *
   * @param          $host_object
   *     A JObject, such as the return of JModelAdmin->getItem()
   * @param null $load_objects
   *     Indicates if loading cascades
   *
   * @since 0.0.1
   */
  public function loadAllObjects($host_object, $load_objects = null) {
    if (is_null($load_objects)) {
      $load_objects = $this->load_objects;
    }

    foreach ($this->_joins as $type => $subtable) {
      $subtable['fk_value'] = $host_object->id;
      $host_object->{$type} = static::loadObject($subtable, $load_objects);
    }
  }
}