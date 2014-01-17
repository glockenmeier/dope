<?php

/*
 * Copyright Copyright 2013, Darius Glockenmeier.
 */

/**
 * Collection utility functions.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage collection
 */
class DopeCollectionUtil {
    
    /**
     * Returns the given iterable object as iterator
     * @param DopeIterable $iterable iterable object
     * @return Iterator
     */
    public static function getIterator(DopeIterable $iterable) {
        return new DopeIteratorAdapter($iterable);
    }
    
    /**
     * Returns the given iterator object as iterable
     * @param Iterator $iterator iterator object
     * @return DopeIterable
     */
    public static function getIterable(Iterator $iterator) {
        return new DopeIterableAdapterAdapter($iterator);
    }
}
