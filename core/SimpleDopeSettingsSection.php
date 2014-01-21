<?php

/*
 * Copyright 2013, Darius Glockenmeier.
 * 
 * Description of SimpleDopeSettingsSection
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 * 
 */
class SimpleDopeSettingsSection extends DopeSettingsSection {
    private $description;
    
    public function __construct($name, $title, $description) {
        parent::__construct($name, $title);
        $this->description = $description;
    }
    
    public function render() {
        echo $this->description;
    }
    
    public function addCheckboxField($name, $default_value, $title, $description) {
        $field = new SimpleDopeSettingsField($name, $title);
        $checkbox = new DopeFormInputCheckbox($name);
        $checkbox->value = 1;
        $checkbox->setChecked(intval(get_option($name, $default_value)));
        $field->setTemplate($checkbox . ' ' . $description);
        $this->addField($field);
    }
    
    public function addNumberField($name, $default_value, $title, $description) {
        $field = new SimpleDopeSettingsField($name, $title);
        $number = new DopeFormInputNumber($name);
        $number->value = intval(get_option($name, $default_value));
        $field->setTemplate($number . ' ' . $description);
        $this->addField($field);
    }
    
    public function addTextField($name, $default_value, $title, $description) {
        $field = new SimpleDopeSettingsField($name, $title);
        $text = new DopeFormInputText($name);
        $text->value = get_option($name, $default_value);
        $field->setTemplate($text . ' ' . $description);
        $this->addField($field);
    }
}