<?php

/*
 * Copyright 2013 Darius Glockenmeie
 */

/**
 * Encapsulates Wordpress Options API
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage wp
 * @link http://codex.wordpress.org/Options_API Options API
 */
class DopeOptions {
    private $prefix;
    
    /**
     * Creates an instance of DopeOptions
     * @param string $prefix prefix to use infront of option
     */
    public function __construct($prefix = '') {
        $this->prefix = strval($prefix);
    }
    /**
     * Add a new option.
     * 
     * @param string $option Name of option to add. Expected to not be SQL-escaped.
     * @param mixed $value Optional. Option value. Must be serializable if non-scalar. Expected to not be SQL-escaped.
     * @param mixed $deprecated Optional. Description. Not used anymore.
     * @param bool $autoload Optional. Default is enabled. Whether to load the option when WordPress starts up.
     * @return bool False if option was not added and true if option was added.
     */
    public function add($option, $value = '', $deprecated = '', $autoload = 'yes') {
        return add_option($this->prefix . $option, $value, $deprecated, $autoload);
    }
    /**
     * Retrieve option value based on name of option.
     * 
     * @param string $option Name of option to retrieve. Expected to not be SQL-escaped.
     * @param mixed $default Optional. Default value to return if the option does not exist.
     * @return mixed Value set for the option.
     */
    public function get($option, $default = false) {
        return get_option($this->prefix . $option, $default);
    }
    
    /**
     * Update the value of an option that was already added.
     * 
     * @param string $option Option name. Expected to not be SQL-escaped.
     * @param mixed $value Option value. Must be serializable if non-scalar. Expected to not be SQL-escaped.
     * @return bool False if value was not updated and true if value was updated.
     */
    public function update($option, $newvalue) {
        return update_option($this->prefix . $option, $newvalue);
    }
    public function delete($option){
        return delete_option($this->prefix . $option);
    }
    
    /**
     * Sets an option prefix.
     * @param string $prefix The prefix.
     */
    public function setPrefix($prefix) {
        $this->prefix = $prefix;
    }
}
