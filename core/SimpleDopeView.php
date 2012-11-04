<?php

/**
 * Simple view. 
 * Slightly modified version of the original WpSimpleBookingCalendar_View
 * the WP Simple Booking Calendar author.
 *
 * @copyright Copyright (c) 2011 WP Simple Booking Calendar
 
 * @author WP Simple Booking Calendar
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @category MVC
 */
class SimpleDopeView implements DopeView, DopeCallable {

    /**
     * View variables array
     * @var array
     */
    protected $vars = array();

    /**
     * Base directory for views
     * @var string
     */
    protected $viewDir = 'view/';

    /**
     * View script extension
     * @var string
     */
    protected $extension = '.inc.php';

    /**
     * Template file name to render
     * @var string
     */
    protected $templateName = null;

    /**
     * The plugin
     * @var DopePlugin
     */
    protected $plugin = null;

    /**
     * Constructor
     */
    public function __construct(DopePlugin $plugin, $templateName = null) {
        $this->plugin = $plugin;
        $this->templateName = $templateName;
    }

    /**
     * Sets a template filename that will be used later in render() method.
     * Performs a reset of the view variables
     * @param string $templateName The template filename, without extension
     * @return SimpleDopeView
     */
    public function setTemplate($templateName) {
        $this->templateName = $templateName;
        $this->vars = array();
        return $this;
    }

    /**
     * Updates the view variable identified by $name with the value provided in $value
     * @param string $name The variable name
     * @param mixed  $value The variable value
     * @return SimpleDopeView
     */
    public function __set($name, $value) {
        $this->vars[$name] = $value;
        return $this;
    }

    /**
     * Updates the view variable identified by $name with the value provided in $value
     * This is an alias for {@link __set()}
     * @param string $name The variable name
     * @param mixed  $value The variable value
     * @return SimpleDopeView
     */
    public function assign($name, $value) {
        return $this->__set($name, $value);
    }

    /**
     * Returns a value of the option identified by $name
     * @param string $name The option name
     * @return mixed|null
     */
    public function __get($name) {
        $value = array_key_exists($name, $this->vars) ? $this->vars[$name] : null;
        return $value;
    }

    /**
     * Renders the view script
     * @param string $template
     * @throws DopeViewException
     * @return SimpleDopeView
     */
    public function render($template = null) {
        $file = $this->plugin->getDirectory() . $this->viewDir . ($template !== null ? $template : $this->templateName) . $this->extension;

        if (!is_readable($file)) {
            throw new DopeViewException(sprintf(__("Can't find view template: %s", 'sbc'), $file));
        }
        include $file;
        return $this;
    }

    /**
     * Returns the rendered view script
     * @return string
     */
    public function fetch($template = null) {
        ob_start();

        $this->render($template);
        $contents = ob_get_contents();

        ob_end_clean();

        return $contents;
    }

    public function getCallback() {
        return array($this, 'render');
    }

}