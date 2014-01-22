<?php

/**
 * @copyright Copyright 2010, Darius Glockenmeier
 */

/**
 * Abstract class for HTML Form Controls
 * 
 * @author Darius Glockenmeier
 * @package core
 * @subpackage form
 * 
 */
abstract class DopeFormElement {

    /**
     * @var string form element's name
     */
    protected $name;
    /**
     * @var string for element's value
     */
    protected $value = null;
    /**
     * @var array CSS class names assigned to this element
     */
    protected $classArray = array();
    protected $customAttributes = array();

    /**
     * Constructs an HTML form element.
     * @param string $name name attribute of the form element
     * @param string $defaultValue optional, used to set the default value. It will be null otherwise
     */
    public function __construct($name, $defaultValue = null) {
        $this->name = $name;
        // set the value if exists in POST or GET, otherwise use default value
        $this->value = ($var = $this->getVariable($name)) !== null ? $var : $defaultValue;
    }

    /**
     * Looks if POST or GET variable is set and returns it.
     * @param string $name name of the variable
     * @param boolean $checkEmpty whether or not to check for emptyness. optional. defaults to true.
     * @return string value of the POST / GET variable, or null if not found
     */
    protected function getVariable($name, $checkEmpty = true) {
        $postEmpty = false;
        $getEmpty = false;
        if ($checkEmpty) {
            $postEmpty = empty($_POST[$name]);
            $getEmpty = empty($_GET[$name]);
        }

        if (isset($_POST[$name]) && !$postEmpty) {
            return $_POST[$name];
        } else if (isset($_GET[$name]) && !$getEmpty) {
            return $_GET[$name];
        }
        return null;
    }

    /**
     * Adds a class name for this form element
     * @param unknown_type $className
     * @return unknown_type
     */
    public function addClass($className) {
        if (is_string($className)) {
            // firefox doesn't support variables starting with a number
            if (is_numeric(substr($className, 0, 1))) {
                throw new InvalidArgumentException('Class name must start with an alphabet or an underscore');
            }
            $this->classArray[] = $className;
        } else {
            throw new InvalidArgumentException('Class name must be a string');
        }
    }

    /**
     * Gets the class attribute part of this form element
     * @return string HTML class attribute containing all class names
     */
    protected function getClassAttribute() {
        return $this->classArray ? 'class="' . join(' ', array_unique($this->classArray)) . '"' : '';
    }

    /**
     * Sets a custom attribute to the element.
     * @param array $attributes array of attribute strings e.g. array('myattribute="myvalue1"',...)
     */
    public function addCustomAttributes(array $attributes) {
        foreach ($attributes as $attrib) {
            if (is_string($attrib)) {
                // firefox doesn't support variables starting with a number
                if (is_numeric(substr($attrib, 0, 1))) {
                    throw new InvalidArgumentException('attribute must start with an alphabet or an underscore');
                }
                $this->customAttributes[] = $attrib;
            } else {
                throw new InvalidArgumentException('attribute name must be a string');
            }
        }
    }

    protected function getCustomAttributes() {
        if (count($this->customAttributes) > 0) {
            return implode(" ", $this->customAttributes);
        } else {
            return "";
        }
    }

    /**
     * Gets a label for this form element.
     * @param string $labelText label description
     * @return string HTML label
     */
    public function getLabel($labelText) {
        return sprintf('<label for="%s">%s</label>',
                htmlspecialchars($this->name),
                htmlspecialchars($labelText));
    }

    /**
     * Magic method overload.
     * @param string $property property name
     * @return mixed returns the property value
     */
    public function __get($property) {
        // create properties for convenience, without needing
        // getter functions
        if ($property == 'value') {
            return $this->value;
        }
        throw new Exception('Unknown property: ' . $property);
    }

    /**
     * Magic method overload.
     * @param string $property property name
     * @param mixed $value property value
     */
    public function __set($property, $value) {
        // create properties for convenience, without needing
        // setter functions
        if ($property == 'value') {
            $this->value = $value;
            return;
        }
        throw new Exception('Unknown property: ' . $property);
    }

    /**
     * Prints the HTML element
     * @param string $label if specified, also creates a label for the element. optional.
     */
    public function printElement($label = null) {
        if ($label !== null) {
            print $this->getLabel($label);
        }
        print $this;
    }

    /**
     * Derived class must implement their own toString method
     * in which it should output the generated HTML element as string.
     * @return string HTML element as it should be displayed in the page.
     */
    public abstract function __toString();
}