<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DopeCustomPostType
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 */
abstract class DopeCustomPostType {

    protected $type;
    protected $options;

    public function __construct($type, $options = array()) {
        $this->type = $type;
        $this->options = $options;
    }

    public function getType() {
        return $this->type;
    }

    public function getOptions() {
        return $this->options;
    }

    /**
     * Adds additional options for the post-type. The options array will be merged according to the same rule as array_replace function.
     * @see array_replace
     * @param array $options aditional options.
     * @param array $key if specified, only affect array with the same key.
     */
    public function addOption($options, $key = null) {
        if ($key != null && array_key_exists($key, $this->options)) {
            array_replace($this->options[$key], $options);
        } else if ($key != null) {
            array_replace($this->options, array($key => $options));
        } else{
            array_replace($this->options, $options);
        }
    }

    /**
     * Register support of certain features for a post type.
     * @link http://codex.wordpress.org/Function_Reference/add_post_type_support
     * @param string|array $feature the feature being added, can be an array of feature strings or a single string
     */
    public function addSupport($feature) {
        add_post_type_support($this->type, $feature);
    }

    /**
     * Remove support for a feature from a post type.
     * @link http://codex.wordpress.org/Function_Reference/remove_post_type_support
     * @param string $feature The feature being removed
     */
    public function removeSupport($feature) {
        remove_post_type_support($this->type, $feature);
    }

    /**
     * Checks the post type's support for a given feature.
     * @link http://codex.wordpress.org/Function_Reference/post_type_supports
     * @param string $feature the feature being checked
     * @return true if supported, false otherwise.
     */
    public function supports($feature) {
        return post_type_supports($this->type, $feature);
    }

    /**
     * Retrieves an object which describes the post type.
     * @return object On success. Nothing on failure (e.g. can check for null).
     */
    public function getObject() {
        return get_post_type_object($this->type);
    }

    /**
     * uilds an object with all post type capabilities out of a post type object
     * @return type 
     */
    public function getCapabilities() {
        return get_post_type_capabilities($this->options);
    }

    /**
     * Whether the post type is hierarchical.
     * @return bool 
     */
    public function isHierarchical() {
        return is_post_type_hierarchical($this->type);
    }

    /**
     * Registers the post type. Do not use before init. 
     * @link http://codex.wordpress.org/Function_Reference/register_post_type 
     */
    public function register() {
        register_post_type($this->type, $this->options);
    }

}
