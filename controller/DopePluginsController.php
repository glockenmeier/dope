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
 */
final class DopePluginsController extends DopeController {

    public function __construct(DopePlugin $plugin) {
        parent::__construct($plugin);

        $this->initSettingsMenu();

        add_action('admin_menu', array($this, 'initPluginsPage'));
        add_action('wp_ajax_dope_install_plugin', array($this, 'ajaxHandler'));
        add_action('wp_ajax_dope_activate_plugin', array($this, 'ajaxHandler'));
        add_action('wp_ajax_dope_deactivate_plugin', array($this, 'ajaxHandler'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    private function initSettingsMenu() {
        //add_query_arg()
    }

    public function ajaxHandler($action) {
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
        $model = new DopePluginsModel();
        if ($action == "dope_deactivate_plugin"){
            $model->disableDopePlugins();
            die("Bye bye cruel world!");
        }
    }

    public function renderDopeDialog() {
        $view = new SimpleDopeView($this->plugin);
        $model = new DopePluginsModel();
        $view->assign("plugins", $model->getPlugins())
                ->render('admin/plugin-dialog');
    }

    public function enqueueScripts() {
        $this->plugin->enqueueScript('dope-plugins', array('jquery-ui-dialog'), false, true);
    }

    public function enqueueStyles() {
        $this->plugin->enqueueStyle('wp-jquery-ui-dialog');
        $this->plugin->enqueueStyle('dope-plugins');
    }

    public function initPluginsPage() {
        $page = add_plugins_page("DOPE based plugins", "DOPE Plugins", "activate_plugins", $this->getHook(), array($this, 'render'));
        //add_action('admin_print_scripts-' . $page, 'enqueuePluginsPageScripts');
        add_action('admin_footer', array($this, 'renderDopeDialog'));
    }
    
    public function enqueuePluginsPageScripts() {
        
    }

    public function indexAction() {
        $view = new SimpleDopeView($this->plugin);
        $model = new DopePluginsModel();
        $plugins = $model->getPlugins(true);
        //$debug = print_r($plugins, true);

        $view->assign("name", "Darius")
                ->assign("plugins", $plugins)
                //->assign("debug", $debug)
                ->assign("controllerUrl", $this->getControllerUrl())
                ->render("admin/plugin-page");
    }

    public function editAction() {
        $view = new SimpleDopeView($this->plugin);

        $view->assign("name", "Edit bla bla")
                ->render("admin/plugin-page");
    }

}

