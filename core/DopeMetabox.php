<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DopeMetabox
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-oo-plugin
 * @subpackage core
 */
abstract class DopeMetabox {

    private $id;
    private $title;
    private $screen;
    private $context;
    private $priority;

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
    
    public abstract function renderMetabox();

}

