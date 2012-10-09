<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DopeShortcode
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-oo-plugin
 * @subpackage core
 */
abstract class DopeShortcode {
    private $tag;
    
    public function __construct($tag) {
         $this->tag = $tag;
   }
    
    /*
     * @see http://codex.wordpress.org/Shortcode_API
     */
    public abstract function processShortcode($atts, $content = '');
    
    public function __get($name) {
        return $this->$name;
    }
}

?>
