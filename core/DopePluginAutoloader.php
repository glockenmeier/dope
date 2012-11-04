<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * The autoloader used to enable autoloading feature for DOPE based plugins.
 * 
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
final class DopePluginAutoloader {

    private $plugin_dir;
    private $dirs = array('controller', 'view', 'model'); // default dirs

    private function __construct($plugin_dir) {
        $this->plugin_dir = $plugin_dir;
    }

    /**
     * Registers a plugin to be loaded as an SPL autoloader.
     * @param string $plugin_dir the plugin directory
     * @return boolean|DopePluginAutoloader boolean false on failure. Returns the loader instance on success.
     */
    public static function register($plugin_dir) {
        $autoloader = new self($plugin_dir);
        $result = spl_autoload_register(array($autoloader, '_autoload'));
        if ($result == false) {
            return false;
        }
        return $autoloader;
    }

    /**
     * This magic method is invoked each time a class is used which has not yet been defined.
     * It should never be invoked manually
     * @param $name class name
     */
    public function _autoload($name) {
        if (is_file($file = $this->plugin_dir . $name . '.php')) {
            require $file;
            return true;
        } else {
            foreach ($this->dirs as $dir) {
                if (file_exists($file = sprintf('%s%s/%s.php', $this->plugin_dir, $dir, $name))) {
                    require $file;
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Adds a directory to be included in the autoloader. Note that directory must be relative to the plugins base directory.
     * @param string $dir 
     */
    public function addDir($dir) {
        if ($dir instanceof string === false) {
            throw new DopeException("Invalid parameter. Expected a string containing directory path");
        }
        if (!in_array($dir, $this->dirs)) {
            array_push($this->dirs, $dir);
        }
    }

}
