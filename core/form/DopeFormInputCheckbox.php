<?php

/**
 * @copyright Copyright 2010, Darius Glockenmeier
 */

/**
 * HTML Form Checkbox
 * @author Darius Glockenmeier
 * @package core
 * @subpackage form
 * 
 */
class DopeFormInputCheckbox extends DopeFormElement {

    /**
     * @var bool checked state of the checkbox
     */
    private $checked = false;

    public function __construct($name) {
        $this->name = $name;

        if ($this->getVariable($name, false) !== null) {
            $this->checked = true;
        }
        $this->value = $this->checked;
    }

    public function __get($property) {
        if ($property === "checked") {
            return $this->checked;
        } else {
            parent::__get($property);
        }
    }
    
    /**
     * Sets the checked state of the checkbox.
     * @param bool $checked true if checkbox is checked, false otherwise
     */
    public function setChecked($checked) {
        $this->checked = $checked ? true : false;
    }

    public function __toString() {
        return sprintf('<input type="checkbox" name="%1$s" id="%1$s" value="%2$s" %3$s %4$s />',
                htmlspecialchars($this->name),
                htmlspecialchars($this->value),
                $this->getClassAttribute(),
                $this->checked === true ? 'checked="checked"' : ''
        );
    }

}