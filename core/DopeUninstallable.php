<?php

/*
 * Copyright 2012 Darius Glockenmeier.
 */

/**
 * Implies that plugin is uninstallable.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
interface DopeUninstallable {
    public function onInstall(DopeEvent $event);
    public function onUninstall(DopeEvent $event);
}
