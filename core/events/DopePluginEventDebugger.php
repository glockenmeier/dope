<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DopePluginEventDebugger
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage events
 */
class DopePluginEventDebugger implements DopePluginEvent {
    private $separator = "================================================";
    private $text = null;
    
    public function __construct() {
        add_action('shutdown', array($this, 'print_text'));
    }
    
    private function log($method, DopePlugin $plugin, DopeEvent $event) {
        $separator = $this->separator;
        $msg = array();
        $msg[] = $separator;
        $msg[] = sprintf("* CLASS: %s", __CLASS__);
        $msg[] = $separator;
        $msg[] = sprintf("* METHOD: %s", $method);
        $msg[] = $separator;
        $msg[] = sprintf("* END OF %s", $method);
        $msg[] = $separator;
        
        $this->add_text(implode("\r\n", $msg));
    }
    
    public function add_text($text) {
        $this->text[] = $text;
    }
    
    public function print_text(){
        $text = implode("\r\n", $this->text);
        printf("<pre>%s</pre>", $text);
    }
    
    public function onActivation(DopePlugin $plugin, $event) {
        $this->log(__METHOD__, $plugin, $event);
    }

    public function onDeactivation(DopePlugin $plugin, $event) {
        $this->log(__METHOD__, $plugin, $event);
    }

    public function onLoad(DopePlugin $plugin, $event) {
        $this->log(__METHOD__, $plugin, $event);
    }

    public function onUnload(DopePlugin $plugin, $event) {
        $this->log(__METHOD__, $plugin, $event);
    }
}
