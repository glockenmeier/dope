<?php

/*
 * Copyright 2013, Darius Glockenmeier.
 */

/**
 * Description of SimpleDopeSettingsField
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
class SimpleDopeSettingsField extends DopeSettingsField {
    private $view;
    
    public function __construct($option_name, $description_text, DopeView $view = null) {
        parent::__construct($option_name, $description_text);
        $this->view = $view;
    }
    
    public function setView(DopeView $view){
        $this->view = $view;
    }
    
    public function setTemplate($text) {
        $view = new SimpleInlineDopeView();
        $view->setTemplate($text);
        $this->setView($view);
    }
    
    public function render() {
        if ($this->view !== null)
            $this->view->render();
    }
}
