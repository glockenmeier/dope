<?php

/**
 * @copyright Copyright 2010, Darius Glockenmeier
 */

/**
 * HTML Form Hidden Input
 * @author Darius Glockenmeier
 * 
 * @package dope
 * @subpackage form
 * 
 */
class DopeFormInputHidden extends DopeFormElement {

    /**
     * override parent's label method to not create label element
     * @override
     * @param string $label
     * @return string
     */
    public function label($label) {
        return '';
    }

    public function __toString() {
        return sprintf('<input type="hidden" name="%1$s" value="%2$s" %3$s />',
                htmlspecialchars($this->name),
                htmlspecialchars($this->value),
                $this->getClassAttribute()
        );
    }

}