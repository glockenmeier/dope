<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Controls the plugin administration page.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-oo-plugin-internal
 * @subpackage controller
 * @internal Controller for plugin activation/deactivation and the DOPE plugin menu subitem.
 * @access private
 */
final class DopePluginsController extends DopeController {
    private $plugin_dir;
    public function __construct(DopePlugin $plugin) {
        parent::__construct($plugin);

        $this->initSettingsMenu();

        add_action('admin_menu', array($this, '_initPluginsPage'), 1);
        add_action('wp_ajax_dope_install_plugin', array($this, '_ajaxHandler'));
        add_action('wp_ajax_dope_activate_plugin', array($this, '_ajaxHandler'));
        add_action('wp_ajax_dope_deactivate_plugin', array($this, '_ajaxHandler'));
        add_action('admin_enqueue_scripts', array($this, '_enqueueStyles'), 1);
        add_action('admin_enqueue_scripts', array($this, '_enqueueScripts'), 1);
        $this->plugin_dir = $plugin->getDirectory();
    }

    private function initSettingsMenu() {
        //add_query_arg()
    }

    public function _ajaxHandler($action) {
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
        $model = new DopePluginsModel();
        if ($action == "dope_deactivate_plugin"){
            $model->disableDopePlugins();
            die("Bye bye cruel world!");
        }
    }

    public function _renderDopeDialog() {
        $view = new SimpleDopeView($this->plugin_dir);
        $model = new DopePluginsModel();
        $view->assign("plugins", $model->getPlugins())
                ->render('admin/plugin-dialog');
    }

    public function _enqueueScripts() {
        $this->plugin->enqueueScript('dope-plugins', array('jquery-ui-dialog'), false, true);
    }

    public function _enqueueStyles() {
        $this->plugin->enqueueStyle('wp-jquery-ui-dialog');
        $this->plugin->enqueueStyle('dope-plugins');
    }

    public function _initPluginsPage() {
        add_plugins_page("DOPE based plugins", "DOPE Plugins", "activate_plugins", $this->getHook(), array($this, 'render'));
        add_action('admin_footer', array($this, '_renderDopeDialog'));
    }
    
    public function enqueuePluginsPageScripts() {
        
    }

    public function defaultAction() {
        $this->indexAction();
    }

    public function indexAction() {
        $view = new SimpleDopeView($this->plugin_dir);
        $model = new DopePluginsModel();
        $plugins = $model->getPlugins(false);

        $view->assign("plugins", $plugins)
                ->assign("controllerUrl", $this->getControllerUrl())
                ->render("admin/plugin-page");
    }

    public function editAction() {
        $view = new SimpleDopeView($this->plugin_dir);

        $view->assign("name", "Edit bla bla")
                ->render("admin/plugin-page");
    }

}

