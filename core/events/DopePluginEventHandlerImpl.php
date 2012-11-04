<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DopePluginEventHandler
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage events
 */
class DopePluginEventHandlerImpl implements DopePluginEventHandler {

    private $plugin;
    private $event = null;
    private $listeners = array();

    public function __construct(DopePlugin $plugin) {
        $this->plugin = $plugin;
        $this->event = DopeEvent::null_event($this);
        $this->plugin->setEventHandler($this);
        
        register_activation_hook($plugin->bootstrapFile, array($this, '_doOnActivation'));
        register_deactivation_hook($plugin->bootstrapFile, array($this, '_doOnDeactivation'));
        $plugin->addAction('init', array($this, '_doOnLoad'));
        $plugin->addAction('shutdown', array($this, '_doOnUnload'));
    }
    
    public function _doOnActivation() {
        $this->plugin->onActivation($this->event);
        
        foreach ($this->listeners as $listener) {
            $listener->onActivation($this->plugin, $this->event);
        }
    }
    
    public function _doOnDeactivation() {
        $this->plugin->onDeactivation($this->event);
        
        foreach ($this->listeners as $listener) {
            $listener->onDeactivation($this->plugin, $this->event);
        }
    }

    public function _doOnLoad() {
        $this->plugin->onLoad($this->event);
        
        foreach ($this->listeners as $listener) {
            $listener->onLoad($this->plugin, $this->event);
        }
    }

    public function _doOnUnload() {
        $this->plugin->onUnload($this->event);
        
        foreach ($this->listeners as $listener) {
            $listener->onUnload($this->plugin, $this->event);
        }
    }

    public function addListener(DopePluginEvent $event) {
        // only if not already registered
        if (array_search($event, $this->listeners, true) === false){
            $this->listeners[] = $event;
            return true;
        }
        return false;
    }

    public function removeListener(DopePluginEvent $event) {
        $key = array_search($event, $this->listeners, true);
        
        if ($key !== false){
            unset($this->listeners[$key]);
            return true;
        }
        return false;
    }

}
