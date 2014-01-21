<?php

/*
 * Copyright 2013, Darius Glockenmeier.
 * 
 * HTML form Number input
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dope
 * @subpackage form
 * 
 */
class DopeFormInputNumber extends DopeFormElement {
    
    public function __get($property) {
        if ($property == "value") {
            return intval($this->value);
        } else {
            parent::__get($property);
        }
    }
    
    public function __toString() {
        return sprintf('<input type="number" name="%1$s" value="%2$d" id="%1$s" %3$s %4$s />',
                htmlspecialchars($this->name),
                intval($this->value),
                $this->getClassAttribute(),
                $this->getCustomAttributes()
        );
    }
}