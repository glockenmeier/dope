<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * A Simple controller base class.
 * Derive from this class if you are planning to use DOPE's simplistic MVC model.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @category MVC
 */
abstract class DopeController {

    protected $class;
    protected $hook;

    /**
     * The plugin
     * @var DopePlugin 
     */
    protected $plugin;

    public function __construct(DopePlugin $plugin) {
        $this->class = new ReflectionClass($this);
        $this->plugin = $plugin;
        $this->hook = $this->createHook();
    }

    /**
     * Gets the hook used for this controller.
     * Default implementation returns dc_YourClassName
     * @return string hook name / menu slug
     */
    public function getHook() {
        return $this->hook;
    }

    private function createHook() {
        $slug = $this->class->getName();
        // remove "Controller" suffix.
        $pos = strrpos($slug, "Controller");
        if ($pos !== false) {
            $slug = substr($this->class->getName(), 0, $pos);
        }
        // remove class prefix
        if (stripos($slug, $this->plugin->getName()) === 0) {
            $slug = str_ireplace($this->plugin->getName(), '', $slug);
        }

        return sprintf("%s/%s", sanitize_title($this->plugin->getName()), sanitize_title($slug));
    }

    /**
     * Gets called when the action request parameter is unspecified. ie. getCurrentAction returns null.
     * @see getCurentAction
     * @see render
     */
    public function defaultAction() {
        // do nothing
    }

    /**
     * Validates and returns current controller action
     * @return string
     */
    protected function getCurrentAction() {
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
        if ($action === false) {
            return null;
        }
        return $action;
    }

    /**
     * Returns controller url. This defaults to the admin url with the slug
     * provided by getHook()
     * @return string this controller's page url
     */
    public function getControllerUrl() {
        return esc_url(admin_url('admin.php?page=' . $this->getHook()));
    }

    /**
     * Renders controller action
     * @return void
     */
    public function render() {

        if ($this->getCurrentAction() === null) {
            $this->defaultAction();
            return;
        }
        $actionMethod = $this->getCurrentAction() . 'Action';
        if (array_search($actionMethod, $this->class->getMethods()) !== false) {
            $this->$actionMethod();
            return;
        }
        // no match, call default
        $this->defaultAction();
    }

    /**
     * Gets the {@see WP_Query} Object.
     * @global WP_Query Uses the global WP_Query class.
     * @return WP_Query
     */
    public static function getQuery() {
        global $wp_query;
        
        if ( ! isset( $wp_query ) ) {
		_doing_it_wrong( __FUNCTION__, __( 'Conditional query tags do not work before the query is run. Before then, they always return false.' ), '3.1' );
		return null;
	}
        return $wp_query;
    }
    
    /**
     * Gets the post object as {@see DopePost}.
     * @global object uses the $post object
     * @return DopePost|null DOPE post object
     */
    public static function getPost() {
        global $post;
        
        if ( !isset( $post )) {
            return null;
        }
        return DopePost::get($post);
    }
}
