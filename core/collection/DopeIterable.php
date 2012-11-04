<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Describes an iterator similar to Java's Iterator interface.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage collection
 */
interface DopeIterable {
    
    /**
     * Whether a next object exists
     * @return boolean true if there are more objects, false otherwise
     */
    public function hasNext();
    /**
     * Gets the next available object
     *  @return mixed
     */
    public function next();
    /**
     * Removes this object from the iteration.
     * @return void 
     */
    public function remove();
}
