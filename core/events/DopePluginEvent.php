<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Describes events that plugins may generate.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage events
 */
interface DopePluginEvent {
    
    /**
     * Gets called when the plugin is about to load. 
     * @param DopePlugin $plugin the event generator
     * @param type $event the event object
     */
    public function onLoad(DopePlugin $plugin, DopeEvent $event);
    
    /**
     * Gets called when the plugin is about to unload. 
     * @param DopePlugin $plugin the event generator
     * @param type $event
     */
    public function onUnload(DopePlugin $plugin, DopeEvent $event);
    
    /**
     * Gets called on plugin activation.
     * @param DopePlugin $plugin the event generator
     * @param type $event
     */
    public function onActivation(DopePlugin $plugin, DopeEvent $event);
    
    /**
     * Gets called on plugin deactivation.
     * @param DopePlugin $plugin the event generator
     * @param type $event
     */
    public function onDeactivation(DopePlugin $plugin, DopeEvent $event);
}
