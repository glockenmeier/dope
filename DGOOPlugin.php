<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * The DOPE plugin itself as a DOPE plugin.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @copyright Copyright 2012, Darius Glockenmeier.
 * @license license.txt
 * @package dg-oo-plugin-internal
 * @access private
 */
final class DGOOPlugin extends DopePlugin {

    private static $instance = null;
    private $adminController;
    private static $initialized = false;

    protected function __construct($bootstrapFile) {
        if (DGOOPlugin::$instance !== null) {
            die(__CLASS__ . " is singleton. Use getInstance() instead.");
        }
        $this->setPriority("init", 1);
        $this->setPriority("admin_init", 1);
        parent::__construct($bootstrapFile);
        
        if (is_admin()) {
            $this->adminController = new DopePluginsController($this);
        }
    }

    /**
     * Returns the instance of dope.
     * @param type $bootstrapFile file path to dope bootstrap file. note that this is set only once at initialization.
     * @return DGOOPlugin dope plugin instance.
     */
    public static function getInstance($bootstrapFile = null) {
        if (self::$instance === null) {
            self::$instance = new self($bootstrapFile);
        }

        return self::$instance;
    }

    public static function init($bootstrapFile) {
        do_action('dope_initializing');
        if (self::$initialized) {
            throw new DopeException("DOPE is already initialized.");
        }
        $info = DopePluginInfo::fromPluginFile($bootstrapFile);
        define('DOPE_PLUGIN', sprintf("%s v%s", $info->getName(), $info->getVersion()));
        define('DOPE_PLUGIN_VERSION', $info->getVersion());
        define('DOPE_BASENAME', plugin_basename($bootstrapFile));
        DopePluginManager::getInstance()->register(self::getInstance($bootstrapFile));
        self::$initialized = true;
        do_action('dope_initialized');
        do_action('dope_ready'); // dependent plugin should use this hook
    }

    /**
     * {@internal Reorder plugin load order on plugin activation, so that dope is the
     * last to activate so that any depending plugin has the chance to add_action.}
     * @access private
     */
    public function _reorderPlugins() {
        $option = 'active_plugins';
        $active_plugins = get_option($option);
        $dope_idx = array_search(DOPE_BASENAME, $active_plugins);
        $dope = $active_plugins[$dope_idx];
        if ($dope_idx > 0) {
            array_splice($active_plugins, $dope_idx, 1);
            array_push($active_plugins, $dope);
        }
        update_option($option, $active_plugins);
    }

    public function onDeactivation($event) {
        parent::onDeactivation($event);
    }

    public function onActivation($event) {
        parent::onActivation($event);
    }

    public function debug($var) {
        $text = printf('<p id="debug"><pre>%s</pre></p>', print_r($var, true));
        return $text;
    }

    public function onLoad($event) {
        // TODO: make a setting, to enable plugin order override. dope first, update action last. to ensure dope is loaded first (DEFAULT)
        $this->setPriority('activated_plugin', 1000000, '_reorderPlugins');
        $this->addAction('activated_plugin', '_reorderPlugins');
        parent::onUnload($event);
    }

    /**
     * Enables exception handler for uncaught exceptions.
     * @internal see {@see createExceptionHandler()}.
     */
    public function enableExceptionHandler() {
        $this->createExceptionHandler();
    }

    private $old_handler = null;

    private function createExceptionHandler() {
        $this->old_handler = set_exception_handler(array($this, '_uncaughtException'));
    }

    /**
     * {@internal exception handler for uncaught exceptions (has to be enabled first)
     * see {@see Description enableExceptionHandler()}.}
     * @access private
     * @param Exception $exception 
     */
    public function _uncaughtException($exception) {
        if ($exception instanceof DopeException) {
            $message = array(
                "Uncaught exception" => $exception->getMessage(),
                "Stacktrace" => $exception->getTrace()
            );
            error_log(print_r($message, true));
        }
        //restore_exception_handler();
        printf("Uncaught exception: %s<br />", $exception->getMessage());
        printf("File: %s on line: %s<br />", $exception->getFile(), $exception->getLine());

        printf("<pre>%s</pre>", print_r($exception, true));
        printf("Backtrace: <br />");
        printf("<pre>%s</pre>", print_r(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 0), true));


        if ($this->old_handler != null) {
            // bubble down to the previous handler
            call_user_func($this->old_handler, $exception);
        }
    }

}
