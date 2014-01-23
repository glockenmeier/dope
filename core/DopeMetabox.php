<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Base class for adding a Metabox Model
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
abstract class DopeMetabox implements DopeCallable {

    protected $id;
    protected $title;
    protected $screen;
    protected $context;
    protected $priority;

    public function __construct($id, $title, $screen = null, $context = 'advanced', $priority = 'default') {
        $this->id = $id;
        $this->title = $title;
        $this->screen = $screen;
        $this->context = $context;
        $this->priority = $priority;
    }

    public function __get($name) {
        return $this->$name;
    }

    /**
     * Note that getCallback will also trigger this function
     * @param type $post
     * @access private
     * @internal get's called when the metabox needs to be rendered.
     */
    public function _doRenderMetabox($post) {
        $this->renderMetabox($post);
    }

    /**
     * Will be called when the metabox needs to be rendered.
     * @param Object $post the post object 
     */
    public abstract function renderMetabox($post);

    /**
     * Returns the render callback
     * @uses _doRenderMetbox render callback function
     * @return array the render callback
     */
    public function getCallback() {
        return array($this, '_doRenderMetabox');
    }

    /**
     * Adds the meta box to an edit form.
     */
    public function add() {
        add_meta_box($this->id, $this->title, $this->getCallback(), $this->screen, $this->context, $this->priority);
    }

}
