<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Describes the minimal requirement for a templated view.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @category MVC
 */
interface DopeView {

    /**
     * Sets a template filename that will be used later in render() method.
     * Performs a reset of the view variables
     * @param string $template The template filename, without extension
     * @return DopeView
     */
    public function setTemplate($templateName);

    /**
     * Updates the view variable identified by $name with the value provided in $value
     * @param string $name The variable name
     * @param mixed  $value The variable value
     * @return DopeView
     */
    public function assign($name, $value);

    /**
     * Renders the view script
     * @param string $template
     * @throws DopeViewException
     * @return DopeView
     */
    public function render($template = null);
}
