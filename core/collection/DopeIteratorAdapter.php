<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * An adapter for DopeIterator interface.
 * It allows a DopeIterable to be accessed as an Iterator
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage collection
 */
class DopeIteratorAdapter implements Iterator {
    private $iterable;
    /**
     *
     * @var DopeIterable
     */
    private $it;
    
    private $next = null;
    private $index = 0;
    
    public function __construct(DopeIterable $iterable) {
        $this->iterable = $iterable;
        $this->rewind();
        
    }

    public function current() {
        return $this->next;
    }

    public function key() {
        return $this->index;
    }

    public function next() {
        $this->next = $this->it->next();
        $this->index++;
    }

    public function rewind() {
        /* to rewind, we clone the original iterable object, prefetch the first
         * element and resets the index.
         */
        $this->it = clone($this->iterable);
        $this->next();
        $this->index = 0;
    }
    
    public function valid() {
        return $this->it->hasNext();
    }
}