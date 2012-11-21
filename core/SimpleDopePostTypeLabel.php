<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * A simple labels implementation for custom post type.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
final class SimpleDopePostTypeLabel extends DopePostTypeLabel {

    private $object = null;

    public function __construct($singular, $plural) {
        parent::__construct($singular, $plural);
    }

    /**
     * Returns as post type label object as expected by register_post_type args.
     * @return array label array
     */
    public function getLabelObject() {
        if ($this->object === null) {
            $this->createLabelObject();
        }
        return $this->object;
    }

    private function createLabelObject() {
        $this->object = array(
            'name' => $this->plural,
            'singular_name' => $this->singular,
            'add_new_item' => sprintf(__('Add New %s', 'dope-label'), $this->singular),
            'edit_item' => sprintf(__('Edit %s', 'dope-label'), $this->singular),
            'new_item' => sprintf(__('Add %s', 'dope-label'), $this->singular),
            'view_item' => sprintf(__('View %s', 'dope-label'), $this->singular),
            'search_items' => sprintf(__('Search %s', 'dope-label'), $this->plural),
            'not_found' => sprintf(__('No %s found', 'dope-label'), $this->plural),
            'not_found_in_trash' => sprintf(__('No %s found in trash', 'dope-label'), $this->plural)
        );
    }

}
