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
 * Base Model
 *
 * @since  0.0.1
 */
abstract class NyccEventsModelBaseAdmin extends JModelAdmin {

    /**
     * Holds definitions of lookups fields.
     * Event Example: array('field'=>'main_location', 'table'=>'locations', 'lookup'=>'name')
     *
     * @var array
     * @since 0.0.1
     */
    protected $_lookups = array();

    /**
     * Easy reference property holding parsed type/name from class name
     *
     * @var bool|mixed
     * @see   NyccEventsHelperUtils::getObjectType()
     * @since 0.0.1
     */
    public $self_type = FALSE;

    /**
     * Constructor.
     *
     * @param   array $config An optional associative array of configuration settings.
     *
     * @see     JModelLegacy
     * @since   0.0.1
     */
    public function __construct($config = array()) {
        parent::__construct($config);

        $this->self_type = NyccEventsHelperUtils::getObjectType($this);
    }

    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string $type   The table name. Optional.
     * @param   string $prefix The class prefix. Optional.
     * @param   array  $config Configuration array for model. Optional.
     *
     * @return  NyccEventsTableBaseTable  A JTable object
     *
     * @since   0.0.1
     */
    public function getTable($type = '', $prefix = 'NyccEventsTable', $config = array()) {
        if (!$type && $this->self_type) {
            $type = $this->self_type->name;
        }

        return NyccEventsTableBaseTable::getInstance($type, $prefix, $config)
            ->setLookups($this->_lookups);
    }

    /**
     * Method to get the record form.
     *
     * @param   array   $data     Data for the form.
     * @param   boolean $loadData True if the form is to load its own data (default case), false if not.
     *
     * @throws  Exception
     * @return  mixed    A JForm object on success, false on failure
     *
     * @since   0.0.1
     */
    public function getForm($data = array(), $loadData = TRUE) {
        if (!$this->self_type) {
            throw new Exception("Class " . get_called_class() . " failed to identify itself");
        }

        // Get the form.
        if ($loadData) {
            $form = $this->loadForm(
                "com_nyccevents.{$this->self_type->name}",
                $this->self_type->name,
                array(
                    'control'   => 'jform',
                    'load_data' => $loadData
                )
            );
        }
        else {
            $form = JForm::getInstance(
                "com_nyccevents.{$this->self_type->name}",
                $this->self_type->name,
                array('control' => 'jform',)
            );
        }

        if ($data) {
            // Allow for additional modification of the form, and events to be triggered.
            // We pass the data because plugins may require it.
            $this->preprocessForm($form, $data);

            // Load the data into the form after the plugins have operated.
            $form->bind($data);
        }

        return empty($form) ? FALSE : $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @throws  Exception
     * @return  mixed  The data for the form.
     *
     * @since   0.0.1
     */
    protected function loadFormData() {

        if (!$this->self_type) {
            throw new Exception("Class " . get_called_class() . " failed to identify itself");
        }

        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState(
            "com_nyccevents.edit.{$this->self_type->name}.data",
            array()
        );

        if (empty($data)) {
            $data = $this->getItem();
        }

        return $data;
    }

}