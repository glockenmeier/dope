<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Manages DOPE based plugin. Plugins are expected to register itself with the
 * manager. Registered plugins receive the neccesary events translated from 
 * Wordpress actions API.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @category Dope API
 * @package core
 * @uses DopePlugin Plugins get registered and processed
 * @uses DopePluginEventHandler Gets attached to plugin(s)
 */
class DopePluginManager {

    private $plugins = array();
    private static $instance = null;

    private function __construct() {
        
    }

    /**
     * Gets the current instance of DopePluginManager.
     * @return DopePluginManager
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function register(DopePlugin $plugin) {
        // only if not already registered
        if (array_search($plugin, $this->plugins, true) === false){
            $this->plugins[] = $plugin;
            
            // attach plugin events
            new DopePluginEventHandlerImpl($plugin);
        }
    }
    
    /**
     * Get all registered plugins
     * @return array array of {@link DopePluginInfo}
     */
    public function getPlugins() {
        $plugins = array();

        foreach ($this->plugins as $p) {
            $plugins[] = new DopePluginInfo($p);
        }
        return $plugins;
    }

}
