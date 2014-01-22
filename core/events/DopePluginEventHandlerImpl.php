<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DopePluginEventHandler
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @subpackage events
 */
class DopePluginEventHandlerImpl implements DopePluginEventHandler {

    private $plugin;
    private $event = null;
    private $listeners = array();
    private $isFirstActivation = false;

    public function __construct(DopePlugin $plugin) {
        $this->plugin = $plugin;
        $this->event = DopeEvent::null_event($this);
        $this->plugin->setEventHandler($this);

        register_activation_hook($plugin->bootstrapFile, array($this, '_doOnInstall'));
        register_activation_hook($plugin->bootstrapFile, array($this, '_doOnActivation'));
        register_deactivation_hook($plugin->bootstrapFile, array($this, '_doOnDeactivation'));
        $plugin->addAction('init', array($this, '_doOnLoad'));
        $plugin->addAction('shutdown', array($this, '_doOnUnload'));

        if ($plugin instanceof DopeUninstallable) {
            register_uninstall_hook($plugin->bootstrapFile, array($this, '_doOnUninstall'));
        }

        $this->isFirstActivation = $this->getActivation();
        
        // TODO: cron to delete leftover / dangling activation-option
    }

    private function getActivation() {
        $opt = $this->getInstallOption();
        $activation = get_option($opt);
        if ($activation === false) {
            add_option($opt, 0, '', true);
            return true;
        }
        return intval($activation) === 0;
    }

    private function getInstallOption() {
        return sprintf("DOPE_plugin_%s", plugin_basename($this->plugin->bootstrapFile));
    }

    public function _doOnInstall() {
        if ($this->isFirstActivation && $this->plugin instanceof DopeUninstallable) {
            $this->plugin->onInstall($this->event);
        }
    }

    public function _doOnUninstall() {
        if ($this->plugin instanceof DopeUninstallable) {
            $this->plugin->onUninstall($this->event);
        }
        delete_option($this->getInstallOption());
    }

    public function _doOnActivation() {
        $this->plugin->onActivation($this->event);
        
        foreach ($this->listeners as $listener) {
            $listener->onActivation($this->plugin, $this->event);
        }
    }

    public function _doOnDeactivation() {
        $this->plugin->onDeactivation($this->event);

        foreach ($this->listeners as $listener) {
            $listener->onDeactivation($this->plugin, $this->event);
        }
    }

    public function _doOnLoad() {
        $this->plugin->onLoad($this->event);

        foreach ($this->listeners as $listener) {
            $listener->onLoad($this->plugin, $this->event);
        }
    }

    public function _doOnUnload() {
        $this->plugin->onUnload($this->event);

        foreach ($this->listeners as $listener) {
            $listener->onUnload($this->plugin, $this->event);
        }
    }

    public function addListener(DopePluginEvent $event) {
        // only if not already registered
        if (array_search($event, $this->listeners, true) === false) {
            $this->listeners[] = $event;
            return true;
        }
        return false;
    }

    public function removeListener(DopePluginEvent $event) {
        $key = array_search($event, $this->listeners, true);

        if ($key !== false) {
            unset($this->listeners[$key]);
            return true;
        }
        return false;
    }

}
