<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DGOOPlugin
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @copyright Copyright 2012, Darius Glockenmeier.
 * @license
 * @package dg-oo-plugin
 * @subpackage core
 */
final class DGOOPlugin extends DopePlugin {
    private static $instance = null;
    private $adminController;
    
    protected function __construct($bootstrapFile) {
        if (DGOOPlugin::$instance !== null){
            die (__CLASS__ . " is singleton. Use getInstance() instead.");
        }
        parent::__construct($bootstrapFile);
        if (is_admin()){
            $this->adminController = new DopePluginsController($this);
        }
    }

    public static function getInstance($bootstrapFile) {
        if (self::$instance === null) {
            self::$instance = new self($bootstrapFile);
        }
        
        return self::$instance;
    }

    public static function init($bootstrapFile) {
        DopePluginManager::getInstance()->register(self::getInstance($bootstrapFile));
        
        //$done = do_action('dope_ready');
    }

    public function reorderPlugins() {
        $option = 'active_plugins';
        $active_plugins = get_option($option);
        $dope_idx = array_search(DOPE_BASENAME, $active_plugins);
        $dope = $active_plugins[$dope_idx];
        if ($dope_idx > 0) {
            array_splice($active_plugins, $dope_idx, 1);
            array_unshift($active_plugins, $dope);
        }
        update_option($option, $active_plugins);
    }
    
    public function onDeactivation() {
        parent::onDeactivation();
    }
    
    public function onActivation() {
        parent::onActivation();
    }

    public function debug($var) {
        $text = printf('<p id="debug"><pre>%s</pre></p>', print_r($var, true));
        return $text;
    }

    //put your code here
    public function getDescription() {
        return "Add's an object oriented plug-in layer for WordPress.";
    }

    public function getName() {
        return "dope";
    }

    public function onLoad() {
        // TODO: make a setting, to enable plugin order override. dope first, update action last. to ensure dope is loaded first (DEFAULT)
        $this->addAction('activated_plugin', 'reorderPlugins', 1000000);
    }
}

