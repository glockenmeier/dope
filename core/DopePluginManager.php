<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of PluginManager
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-oo-plugin
 * @subpackage core
 */
class DopePluginManager {

    private $plugins = array();
    private static $instance;

    private function __construct() {
        $this->init();
    }

    protected function init() {
        //add_action('init', array($this, '__loadPlugins'));
        //add_action('shutdown', array($this, '__unloadPlugins'));
    }

    /**
     * Gets the current instance of DPluginManager.
     * @return DopePluginManager
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    public function __loadPlugins() {
        foreach ($this->plugins as $k => $v) {
            if ($v instanceof DopePlugin) {
                $v->onLoad();
            }
        }
    }

    public function __unloadPlugins() {
        foreach ($this->plugins as $k => $v) {
            if ($v instanceof DopePlugin) {
                $v->onUnload();
            }
        }
    }

    public function register(DopePlugin $plugin, $useAutoloader = false) {
        // only if not already registered
        if (array_search($plugin, $this->plugins, true) === false){
            $this->plugins[] = $plugin;
            if ($useAutoloader === true){
                $this->registerAutoloader($plugin);
            }
        }
    }

    private function registerAutoloader($plugin){
        throw new DopePluginException("Not implemented yet.");
        // TODO: Iterate through common dirs.
    }
    
    /**
     * Get all registered plugins
     * @return \DopePluginInfo 
     */
    public function getPlugins() {
        $plugins = array();

        foreach ($this->plugins as $p) {
            $plugins[] = new DopePluginInfo($p);
        }
        return $plugins;
    }

}