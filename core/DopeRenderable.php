<?php
/*
 * Copyright 2013, Darius Glockenmeier.
 */

/**
 * Describes a renderable object.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
abstract class DopeRenderable implements DopeCallable {
    
    public abstract function render();
    
    public function _doRender() {
        $this->render();
    }
    
    //put your code here
    public function getCallback() {
        return array($this, '_doRender');
    }
}
