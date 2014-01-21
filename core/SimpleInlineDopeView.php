<?php

/*
 * Copyright 2013, Darius Glockenmeier.
 */

/**
 * Description of SimpleInlineDopeView
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
class SimpleInlineDopeView extends DopeRenderable implements DopeView {
    private $vars = array(); // variable arrays
    private $template;
    
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
    
    public function render($template = null) {
        if (!empty($template) || $template != null)
            DopeUtil::ob_safe_clean ();
            echo $this->template;
        return $this;
    }

    public function setTemplate($templateText) {
        $this->template = $templateText;
    }
}
