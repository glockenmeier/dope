<?php

dope_autoloader::register();

/**
 * @package dg-oo-plugin-internal
 * @internal DOPE's Autoloader
 * @access private
 */
final class dope_autoloader {

    private $plugin_dir;

    public function __construct() {
        $this->plugin_dir = plugin_dir_path(__FILE__);
    }

    /**
     * Registers dg_oo_plugin_autoloader as an SPL autoloader.
     */
    public static function register() {
        //ini_set('unserialize_callback_func', 'spl_autoload_call');
        spl_autoload_register(array(new self, 'autoload'));
    }

    /**
     * This magic method is invoked each time a class is used which has not yet been defined.
     * @param $name class name
     */
    public function autoload($name) {
        $dirs = array('core', 'core/exceptions', 'core/collection', 'core/events', 'core/wp', 'core/form', 'controller', 'model', 'view');
        
        if (is_file($file = $this->plugin_dir . $name . '.php')) {
            require $file;
            return true;
        } else {
            while (list($k, $dir) = each($dirs)) {
                if (is_file($file = sprintf('%s%s/%s.php', $this->plugin_dir , $dir, $name))) {
                    require $file;
                    return true;
                }
            }
            // TODO: iterate through lib folder last
        }
        return false;
    }

}
