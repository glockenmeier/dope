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
    public function __construct($prefix = '') {
        $this->prefix = $prefix;
    }
    
    public function add($option, $value = '', $deprecated = '', $autoload = 'yes') {
        return add_option($this->prefix . $option, $value, $deprecated, $autoload);
    }
    public function get($option, $default = false) {
        return get_option($this->prefix . $option, $default);
    }
    public function update($option, $newvalue) {
        return update_option($this->prefix . $option, $newvalue);
    }
    public function delete($option){
        return delete_option($this->prefix . $option);
    }
    
    public function setPrefix($prefix) {
        $this->prefix = $prefix;
    }
}
