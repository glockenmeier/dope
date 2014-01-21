<?php

/*
 * Copyright 2013, Darius Glockenmeier.
 */

/**
 * WordPress Settings API
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @category api
 */
abstract class DopeSettingsSection extends DopeRenderable
{
    protected $fields = array();
    protected $name;
    protected $title;
    
    public function __construct($name, $title) {
        $this->name = $name;
        $this->title = $title;
    }
    
    public function addField(DopeSettingsField $field) {
        if (array_key_exists($field->getOption(), $this->fields))
                return false;
        
        array_push($this->fields, $field);
        return true;
    }
    
    public function removeField(DopeSettingsField $field) {
        if (!array_key_exists($field->getOption(), $this->fields))
                return false;
        
        unset($this->fields[$field->getOption()]);
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getFields() {
        return $this->fields;
    }
}
