<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DopeEventHandler
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage events
 */
interface DopePluginEventHandler {
    
    public function addListener(DopePluginEvent $event);
    public function removeListener(DopePluginEvent $event);
}
