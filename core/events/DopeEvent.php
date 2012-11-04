<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DopeEvent
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage events
 */
class DopeEvent {
    private $caller = null;
    
    public function __construct($caller) {
        $this->caller = $caller;
    }
    
    /**
     * Creates an instance with nothing attached
     * @param type $caller
     * @return DopeEvent
     */
    public static function null_event($caller) {
        return new self($caller);
    }
    
    /**
     * Object that produced the event
     * @return object
     */
    public function getCaller() {
        return $this->caller;
    }
}
