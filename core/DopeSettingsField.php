<?php

/*
 * Copyright 2013, Darius Glockenmeier.
 */

/**
 * WordPress Settings API
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @category api
 */
 abstract class DopeSettingsField extends DopeRenderable {
    protected $option;
    protected $description;
    
    public function DopeSettingsField($option_name, $description_text) {
        $this->option = $option_name;
        $this->description = $description_text;
    }
    
    public function getOption() {
        return $this->option;
    }
    
    public function getDescription() {
        return $this->description;
    }
}
