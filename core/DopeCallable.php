<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Implies that a class is callable through a callback
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
interface DopeCallable {
    
    /**
     * Returned function will be registered as a callback function
     * @return array|string array or string containing the callback function.
     */
    public function getCallback();
}
