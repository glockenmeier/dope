<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Provides abstraction for Shortcode on Wordpress
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @todo add some other shortcode related functions http://codex.wordpress.org/Function_Reference
 */
abstract class DopeShortcode implements DopeCallable {

    private $tag;

    public function __construct($tag) {
        $this->tag = $tag;
    }

    /*
     * 
     * @see http://codex.wordpress.org/Shortcode_API
     */
    protected abstract function processShortcode($atts, $content = '');

    public function _doProcessShortcode($atts, $content = '') {
        $this->processShortcode($atts, $content);
    }

    public function __get($name) {
        return $this->$name;
    }
    
    public function getCallback() {
        return array($this, '_doProcessShortcode');
    }
    
    public function add() {
        add_shortcode($this->tag, $this->getCallback());
    }
    
    public function remove() {
        remove_shortcode($this->tag);
    }
    
    public static function remove_all() {
        remove_all_shortcodes();
    }
}
