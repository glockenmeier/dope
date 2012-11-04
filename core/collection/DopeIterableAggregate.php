<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Describe an aggregate class containing an iterable. Similar to PHP's {@see IteratorAggregate}.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage collection
 */
interface DopeIterableAggregate {
    /**
     * @return DopeIterable 
     */
    public function getIterable();
}
