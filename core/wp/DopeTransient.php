<?php

/*
 * Copyright 2013, Darius Glockenmeier.
 */

/**
 * Encapsulates Wordpress Transients API
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage wp
 * @link http://codex.wordpress.org/Transients_API
 */
class DopeTransient {
    private $prefix;
    
    /**
     * 
     * @param string $prefix
     */
    public function __construct($prefix = '') {
        $this->prefix = strval($prefix);
    }
    
    /**
     * Set/update the value of a transient.
     *
     * You do not need to serialize values. If the value needs to be serialized, then
     * it will be serialized before it is set.
     *
     * @since 2.8.0
     * @package WordPress
     * @subpackage Transient
     *
     * @uses apply_filters() Calls 'pre_set_transient_$transient' hook to allow overwriting the
     * 	transient value to be stored.
     * @uses do_action() Calls 'set_transient_$transient' and 'setted_transient' hooks on success.
     *
     * @param string $transient Transient name. Expected to not be SQL-escaped.
     * @param mixed $value Transient value. Expected to not be SQL-escaped.
     * @param int $expiration Time until expiration in seconds, default 0
     * @return bool False if value was not set and true if value was set.
     */
    public function set($transient, $value, $expiration = 0) {
        return set_transient($this->prefix . $transient, $value, $expiration);
    }
    /**
     * Get the value of a transient.
     *
     * If the transient does not exist or does not have a value, then the return value
     * will be false.
     *
     * @uses apply_filters() Calls 'pre_transient_$transient' hook before checking the transient.
     * 	Any value other than false will "short-circuit" the retrieval of the transient
     *	and return the returned value.
     * @uses apply_filters() Calls 'transient_$option' hook, after checking the transient, with
     * 	the transient value.
     *
     * @since 2.8.0
     * @package WordPress
     * @subpackage Transient
     *
     * @param string $transient Transient name. Expected to not be SQL-escaped
     * @return mixed Value of transient
     */
    public function get($transient) {
        return get_transient($this->prefix . $transient);
    }
    /**
     * Delete a transient.
     *
     * @since 2.8.0
     * @package WordPress
     * @subpackage Transient
     *
     * @uses do_action() Calls 'delete_transient_$transient' hook before transient is deleted.
     * @uses do_action() Calls 'deleted_transient' hook on success.
     *
     * @param string $transient Transient name. Expected to not be SQL-escaped.
     * @return bool true if successful, false otherwise
     */
    public function delete($transient){
        return delete_transient($this->prefix . $transient);
    }
}