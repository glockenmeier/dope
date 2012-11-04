<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * An adapter for PHP's Iterator interface.
 * It essentially wraps the iterator as iterable and call the appropriate PHP's Iterator
 * methods equivalent to Iterables.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage collection
 */
class DopeIterableAdapter implements DopeIterable {
    private $iterator = null;
    
    public function __construct(Iterator $iterator) {
        $this->iterator = $iterator;
    }

    public function hasNext() {
        $this->iterator->valid();
    }

    public function next() {
        // Iterator prefetches current
        $this->iterator->current();
        $this->iterator->next();
    }

    public function remove() {
        throw new Exception("Not Implemented");
    }
}
