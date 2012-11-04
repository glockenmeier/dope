<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Class to iterate over an array
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage collection
 */
class DopeArrayIterator implements DopeIterable {
    protected $array;
    protected $idx = 0;
    
    public function __construct($array) {
        $array = is_array($array) ? $array : array();
        $this->array = array_values($array);
    }
    
    /**
     * If next element is available
     * @return boolean 
     */
    public function hasNext() {
        if ($this->idx < count($this->array)){
            return true;
        }
        return false;
    }

    /**
     * The next element
     * @return mixed
     */
    public function next() {
        return $this->array[$this->idx++];
    }

    /**
     * Removes the element pointed by next 
     */
    public function remove() {
        unset($this->array[$this->idx]);
    }

}
