<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Provides an abstraction for the label object used in DopePostType
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
abstract class DopePostTypeLabel {

    protected $singular;
    protected $plural;

    /**
     * Reflection class
     * @var ReflectionClass
     */
    protected $class;

    public function __construct($singular, $plural) {
        $this->class = new ReflectionClass(get_class($this));
        $this->singular = __($singular, $this->class->getName());
        $this->plural = __($plural, $this->class->getName());
    }

    public function getSingular() {
        return $this->singular;
    }

    public function getPlural() {
        return $this->plural;
    }

    /**
     * Returns as post type label object as expected by register_post_type args.
     * @return array label array
     */
    public abstract function getLabelObject();
}
