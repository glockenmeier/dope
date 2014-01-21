<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Base class for DOPE based plugin.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
abstract class DopePlugin {

    private $reflection = null;
    private $pluginDir;
    private $pluginUrl;
    private $cssDir;
    private $cssUrl;
    private $jsDir;
    private $jsUrl;
    private $bootstrapFile;
    private $wp_version;
    /**
     * WP error object
     * @var WP_Error
     */
    protected $wpError;
    private $actionPriority = array();
    protected $eventHandler = null;

    /**
     * 
     * @param string $bootstrapFile name including full path of the bootstrap file (plugin entry point). passing __FILE__ usually suffice if file is located in base plugin directory.
     */
    protected function __construct($bootstrapFile) {

        if ($bootstrapFile === null) {
            throw new DopePluginException("Missing parameter: bootstrapFile cannot be null");
        }
        $this->bootstrapFile = $bootstrapFile;
        $this->_init();
    }

    protected $shortcodes = array();

    protected function registerShortcode(DopeShortcode $shortcode) {
        return $this->array_add_new($this->shortcodes, $shortcode);
    }

    protected $metaboxes = array();

    protected function addMetabox(DopeMetabox $metabox) {
        return $this->array_add_new($this->metaboxes, $metabox);
    }

    private function array_add_new($array, $var) {
        if (!in_array($var, $array)) {
            array_push($var, $array);
            return true;
        }
        return false;
    }

    /**
     * List of all controllers registered.
     * @var array
     */
    protected $controllers = array();

    protected function addController(DopeController $controller) {
        $this->array_add_new($this->controllers, $controller);
    }

    public function getControllers() {
        return $this->controllers;
    }

    /**
     * Gets the display name of the plugin.
     */
    public function getName() {
        return plugin_basename($this->bootstrapFile);
    }

    /**
     * Gets the plugin description. 
     */
    public function getDescription() {
        $pi = DopePluginInfo::fromPlugin($this);
        return $pi->getDescription();
    }

    /**
     * Called when the plugin is about to load. 
     */
    public function onLoad($event) {
        
    }

    /**
     * Called when the plugin is about to unload. 
     */
    public function onUnload($event) {
        
    }
    
    /**
     * Called when the plugin is being activated. 
     */
    public function onActivation($event) {
        
    }
    
    /**
     * Called when the plugin is going to be deactivated. 
     */
    public function onDeactivation($event) {
        
    }
    
    /**
     * Returns the directory path of the plugin.
     * @return string
     */
    public function getDirectory() {
        return $this->pluginDir;
    }

    /**
     * Returns the filename of the plugin.
     * @return type 
     */
    public function getFilename() {
        return $this->reflection->getFileName();
    }

    /**
     * Returns an url pointing to this plugin directory.
     * @return type 
     */
    public function getUrl() {
        return $this->pluginUrl;
    }

    /**
     * Enqueue stylesheet to wp given the name.
     * This function searches for the given file in the css/ directory of your plugin.
     * If the file is not found, it would just enqueues it as a handle.
     * @param type $name name of the sylesheet (without .css the extension)
     */
    public function enqueueStyle($name, $src = false, $deps = array(), $ver = false, $media = 'all') {
        $fileName = is_rtl() && is_readable($this->cssDir . $name . "_rtl.css") ? $name . "_rtl.css" : $name . ".css";

        if (!is_readable($this->cssDir . $fileName)) {
            wp_enqueue_style($this->stripDir($name));
            return;
        }
        wp_enqueue_style($this->stripDir($name), $this->cssUrl . $fileName, $deps, $ver, $media);
    }

    /**
     * Strips all paths from a file
     * @param string $file file name with paths
     * @return string file name without paths
     */
    private function stripDir($file) {
        $name = explode('/', $file);
        if ($name !== false) {
            return array_pop($name);
        }
        return $file;
    }

    /**
     * Enqueue javascript file to wp with given the name.
     * This function searches for the given file in the js/ directory of your plugin.
     * If the file is not found, it would just enqueues it as a handle.
     * @param type $name name (including path if any) of the javascript file (without .js extension).
     */
    public function enqueueScript($name, $deps = array(), $ver = false, $in_footer = false) {
        $ext = ".js";

        if (!is_readable($this->jsDir . $name . $ext)) {
            wp_enqueue_script($this->stripDir($name));
            return;
        }
        wp_enqueue_script($this->stripDir($name), $this->jsUrl . $name . $ext, $deps, $ver, $in_footer);
    }

    protected function _init() {
        $this->wpError = new WP_Error();
        // note: when you create ReflectionClass object and assigning to
        // $this->reflection without storing it in a local variable first
        // PHP throws an error
        $r = new ReflectionClass(get_class($this));
        $this->reflection = $r;

        $this->pluginDir = plugin_dir_path($r->getFileName());
        $this->pluginUrl = plugin_dir_url($r->getFileName());

        $this->cssDir = $this->pluginDir . "css/";
        $this->cssUrl = $this->pluginUrl . "css/";
        $this->jsDir = $this->pluginDir . "js/";
        $this->jsUrl = $this->pluginUrl . "js/";

        global $wp_version;
        $this->wp_version = $wp_version;

        $this->init_shortcodes();
        $this->init_metaboxes();
    }
    
    public function setEventHandler(DopePluginEventHandler $eventHandler) {
        $this->eventHandler = $eventHandler;
    }
    
    /**
     * 
     * @return DopePluginEventHandler
     */
    public function getEventHandler() {
        return $this->eventHandler;
    }

    private function init_shortcodes() {
        foreach ($this->shortcodes as $shortcode) {
            if ($shortcode instanceof DopeShortcode) {
                $shortcode->add();
            }
        }
    }

    private function init_metaboxes() {
        foreach ($this->metaboxes as $m) {
            if ($m instanceof DopeMetabox) {
                $m->add();
            }
        }
    }

    /**
     * Get the Wordpress error object associated with the plugin.
     * @return WP_Error Error object
     */
    public function getWpError() {
        return $this->wpError;
    }

    protected function setPriority($action, $priority, $function_to_add = null) {
        $key = $this->createKey($action, $function_to_add);
        if (array_key_exists($key, $this->actionPriority)) {
            $this->actionPriority[$key] = $priority;
            return;
        }
        array_push($this->actionPriority, array($key => $priority));
    }

    public function getPriority($action, $function_to_add = null) {
        $key = $this->createKey($action, $function_to_add);
        if (array_key_exists($key, $this->actionPriority)) {
            $priority = $this->actionPriority[$key];
        } else {
            $priority = null;
        }
        return $priority;
    }

    private function createKey($action, $function_to_add) {
        $func = is_array($function_to_add) ? sprintf("%s:%s", get_class($function_to_add[0]), $function_to_add[1]) : $function_to_add;
        return $func !== null ? sprintf("%s_%s", $action, $func) : $action;
    }

    public function addAction($tag, $function_to_add, $accepted_args = 1) {
        $priority = $this->getPriority($tag, $function_to_add);
        if ($priority === null) {
            $priority = 10; // defaults to 10
        }
        $func = is_array($function_to_add) ? $function_to_add : array($this, $function_to_add);
        add_action($tag, $func, $priority, $accepted_args);
    }

    /**
     * Properties for convenience.
     * @param type $name property name
     * @return string property value
     * @throws Exception on unknown property
     */
    public function __get($name) {
        switch ($name) {
            case "jsDir":
                return $this->jsDir;
            case "cssDir":
                return $this->cssDir;
            case "jsUrl":
                return $this->jsUrl;
            case "cssUrl":
                return $this->cssUrl;
            case "pluginDir":
                return $this->pluginDir;
            case "pluginUrl":
                return $this->pluginUrl;
            case "bootstrapFile":
                return $this->bootstrapFile;
            case "wp_version":
                return $this->wp_version;
            case "actionPriority":
                return $this->actionPriority;
            default:
                throw new Exception("Unknown property: " . $name);
        }
    }

}
