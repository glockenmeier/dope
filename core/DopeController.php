<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DController
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-oo-plugin
 * @subpackage core
 */
abstract class DopeController {

    private $reflection;
    private $methods = array();
    private $hook;

    /**
     * The plugin
     * @var DopePlugin 
     */
    protected $plugin;

    public function __construct(DopePlugin $plugin) {
        $this->reflection = new ReflectionClass(get_class($this));
        $this->plugin = $plugin;
        $this->methods = get_class_methods($this);
        $this->hook = $this->createHook();
    }

    /**
     * Gets the hook used for this controller.
     * Default implementation returns dc_YourClassName
     * @return string hook name / menu slug
     */
    public function getHook() {
        return $this->hook;
    }
    
    private function createHook(){
        $slug = $this->reflection->getName();
        // remove "Controller" suffix.
        $pos = strrpos($slug, "Controller");
        if ($pos !== false){
            $slug = substr($this->reflection->getName(), 0, $pos);
        }
        // remove class prefix
        if (stripos($slug, $this->plugin->getName()) === 0){
            $slug = str_ireplace($this->plugin->getName(), '', $slug);
        }
        
        return sprintf("%s/%s", $this->plugin->getName(), $slug);
    }
    
    /**
     * Gets called when the URL action parameter is unspecified or contains 
     * the value "index".
     */
    public abstract function indexAction();

    /**
     * Validates and returns current controller action
     * @return string
     */
    protected function getCurrentAction() {
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
        return $action;
    }

    /**
     * Returns controller url. This defaults to the admin url with the slug
     * provided by getHook()
     * @return string this controller's page url
     */
    public function getControllerUrl() {
        return esc_url(admin_url('admin.php?page=' . $this->getHook()));
    }

    /**
     * Renders controller action
     * @return void
     */
    public function render() {
        $actionMethod = $this->getCurrentAction() . 'Action';
        if (array_search($actionMethod, $this->methods) !== false) {
            $this->$actionMethod();
            return;
        }
        // defaults to index
        $this->indexAction();
    }

}
