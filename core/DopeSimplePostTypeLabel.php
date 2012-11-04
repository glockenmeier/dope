<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * A simple labels implementation for custom post type.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @todo TODO: maybe some abstraction?
 */
class DopeSimplePostTypeLabel {
    private $singular;
    private $plural;
    private $object;
    public function __construct($singular, $plural) {
        $this->singular = $singular;
        $this->plural = $plural;
        $this->object = array(
        'name' => $plural,
        'singular_name' => $singular,
        'add_new_item' => sprintf(__('Add New %s', 'dope-label'), $singular),
        'edit_item' => sprintf(__('Edit %s', 'dope-label'), $singular),
        'new_item' => sprintf(__('Add %s', 'dope-label'), $singular),
        'view_item' => sprintf(__('View %s', 'dope-label'), $singular),
        'search_items' => sprintf(__('Search %s', 'dope-label'), $plural),
        'not_found' => sprintf(__('No %s found', 'dope-label'), $plural),
        'not_found_in_trash' => sprintf(__('No %s found in trash', 'dope-label'), $plural)
        );
    }
    
    public function getSingular(){
        return $this->singular;
    }
    
    public function getPlural(){
        return $this->plural;
    }
    
    /**
     * Returns as post type label object as expected by register_post_type args.
     * @return array label array
     */
    public function getLabelObject(){
        return $this->object;
    }
}
