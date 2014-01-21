<?php

/**
 * @copyright Copyright 2010, Darius Glockenmeier
 */

/**
 * HTML Form Selectbox
 * 
 * @author Darius Glockenmeier
 * @package dope
 * @subpackage form
 * 
 */
class DopeFormInputSelect extends DopeFormElement {

    private $items = array();

    /**
     * Constructs a Selectbox with the specified name and array of key/values
     * @param unknown_type $name
     * @param array $items array containing arrays of 'k'=>'mykey', 'v'=>'myvalue', optional 'class=>'myclass'
     * @return complete HTML select box
     */
    public function __construct($name, array $items) {
        parent::__construct($name);
        $this->items = $items;
    }

    /**
     * Creates an array with key / value pairs given a single dimension array.
     * Key and value will have the same content.
     * @example $a[] will translate to: $b[] = array('k'=>$a, 'v'=>$a);
     * @param $array a single dimensional array to convert.
     */
    public static function singleArrayToKV($array) {
        $result = array();
        foreach ($array as $a) {
            $result[] = array('k' => $a, 'v' => $a);
        }
        return $result;
    }

    /**
     * Sets an entry as selected by it's key.
     * @param the key or id of the array $key
     */
    public function setSelected($key) {
        $this->value = $key;
    }

    public function __toString() {
        $result = sprintf('<select name="%1$s" id="%1$s" %2$s %3$s >',
                        htmlspecialchars($this->name),
                        $this->getClassAttribute(),
                        $this->getCustomAttributes()
        );
        foreach ($this->items as $akt) {
            $selected = isset($this->value) && $this->value == $akt['k'] ? 'selected="selected"' : '';
            $result .= sprintf('<option value="%1$s" %4$s %3$s >%2$s</option>',
                            htmlspecialchars($akt['k']),
                            htmlspecialchars($akt['v']),
                            $selected,
                            isset($akt['class']) ? 'class="' . htmlspecialchars($akt['class']) . '"' : ''
            );
        }
        return $result .= '</select>';
    }

}