<?php

/**
 * @copyright Copyright 2010, Darius Glockenmeier
 */

/**
 * HTML Form Textbox
 * 
 * @author Darius Glockenmeier
 * @package core
 * @subpackage form
 * 
 */
class DopeFormInputText extends DopeFormElement {

    private $sizeAttribute = '';
    private $maxLengthAttribute = '';

    /**
     * Sets the size of the textbox.
     * @param $size
     */
    public function setSize($size) {
        if ($size > 0) {
            $this->sizeAttribute = sprintf('size="%d"', $size);
        }
    }

    /**
     * Sets the maximum character length that should fit in the textbox.
     * @param $length
     */
    public function setMaxLength($length) {
        if ($length > 0) {
            $this->maxLengthAttribute = sprintf('maxlength="%d"', $length);
        }
    }

    public function __toString() {
        return sprintf('<input type="text" name="%1$s" value="%2$s" id="%1$s" %3$s %4$s %5$s %6$s />',
                htmlspecialchars($this->name),
                htmlspecialchars($this->value),
                $this->getClassAttribute(),
                $this->sizeAttribute,
                $this->maxLengthAttribute,
                $this->getCustomAttributes()
        );
    }

}