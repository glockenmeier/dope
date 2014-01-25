<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * An abstraction around Wordpress meta.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
class DopePostMeta {

    protected $post_id;
    protected $meta_prefix;

    public function __construct($post_id, $meta_prefix) {
        $this->post_id = $post_id;
        $this->meta_prefix = $meta_prefix;
    }

    /**
     * Creates a prefixed key.
     * @param string $key Metadata key.
     * @return string the prefixed Metadata key
     */
    protected function createKey($key) {
        return sprintf('%s%s', $this->meta_prefix, $key);
    }

    protected function processKey($key) {
        return $this->createKey($key);
    }

    protected function processValue($value) {
        $this->maybe_unserialize_recursive($value);
        return $value;
    }

    /**
     * Add meta data field to the post.
     * @param string $key Metadata key. If same key already exists, it will not be added.
     * @param mixed $value Metadata value.
     * @return bool False for failure. True for success.
     * @link http://codex.wordpress.org/Function_Reference/add_post_meta
     */
    public function add($key, $value) {
        return add_post_meta($this->post_id, $this->processKey($key), $value, true);
    }

    /**
     *
     * @param string $key Metadata key.
     * @param mixed $value Metadata value.
     * @return mixed Returns meta_id if the meta doesn't exist, otherwise returns true on success and false on failure. NOTE: If the meta_value passed to this function is the same as the value that is already in the database, this function returns false.
     * @link http://codex.wordpress.org/Function_Reference/update_post_meta
     */
    public function update($key, $value) {
        return update_post_meta($this->post_id, $this->processKey($key), $value);
    }

    protected function delete_no_prefix($key) {
        return delete_post_meta($this->post_id, $key);
    }

    /**
     * Remove metadata matching criteria from a post.
     * @param string $key Metadata key.
     * @return bool False for failure. True for success.
     */
    public function delete($key) {
        return $this->delete_no_prefix($this->processKey($key));
    }

    public function deleteAll() {
        $fields = get_post_custom($this->post_id);
        foreach ($fields as $k => $v) {
            if (stripos($k, $this->meta_prefix) === 0) {
                $this->delete_no_prefix($k);
            }
        }
    }

    /**
     * Retrieve post meta field for a post.
     * @param string $key Metadata key.
     * @return mixed If there is nothing to return the function will return an empty string.
     */
    public function get($key) {
        $value = get_post_meta($this->post_id, $this->processKey($key), true);
        return $this->processValue($value);
    }

    /**
     * Filters out metadata without the defined meta_prefix.
     * @param type $fields
     * @return null|array 
     */
    private function filterFields(array $fields) {
        if ($fields === null) {
            return null;
        }

        foreach ($fields as $k => $v) {
            // remove unwanted fields
            if (stripos($k, $this->meta_prefix) !== 0) {
                unset($fields[$k]);
                continue;
            }
            $prefix_len = strlen($this->meta_prefix) + 1; // plus one underscore after the prefix
            $key = substr($k, $prefix_len);
            // set the new key
            $fields[$key] = $this->processValue($v);
            // remove the old one
            unset($fields[$k]);
        }
        if (count($fields) === 0) {
            return null;
        }

        return $fields;
    }

    private function maybe_unserialize_recursive(&$original) {
        // first check if it's a serialized string
        if (is_string($original)) {
            $original = maybe_unserialize($original);
            return;
        }
        // unserialized string may be an array
        if (is_array($original)) {
            // walk down
            foreach ($original as $k => $v) {
                $this->maybe_unserialize_recursive($v);
                $original[$k] = maybe_unserialize($v);
            }
        }
    }

    /**
     * Retrieve all meta field (with the matching prefix) for this post 
     * @return array|null Returns an associative array containing the metadata key and values (Key => Value).
     */
    public function getAll() {
        $fields = get_post_custom($this->post_id);

        if ($fields === null){
            return null;
        }

        return $this->filterFields($fields);
    }

    /**
     * Retrieve all meta keys for this post
     * @return array|null Returns an array containing the metadata key.
     */
    public function getKeys() {
        $fields = get_post_custom_keys($this->post_id);
        // filter needs assoc. array
        if ($fields === null){
            return null;
        }
        $fields = $this->filterFields(array_combine($fields, $fields));
        return $fields !== null ? array_keys($fields) : null;
    }

    /**
     * The post id.
     * @return string
     */
    public function getPostId() {
        return $this->post_id;
    }

    /**
     * The prefix.
     * @return string 
     */
    public function getMetaPrefix() {
        return $this->meta_prefix;
    }

}
