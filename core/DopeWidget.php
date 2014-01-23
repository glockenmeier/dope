<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Wordpress Widget abstraction.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @todo TODO: see if it's not better to abstarct this away, instead of extending WP_Widget...
 */
abstract class DopeWidget extends WP_Widget {

    /**
     * PHP5 constructor
     *
     * @param string $name Name for the widget displayed on the configuration page.
     * @param string $id_base Optional Base ID for the widget, lower case,
     * if left empty a portion of the widget's class name will be used. Has to be unique.
     * @param array $widget_options Optional Passed to wp_register_sidebar_widget()
     * 	 - description: shown on the configuration page
     * 	 - classname
     * @param array $control_options Optional Passed to wp_register_widget_control()
     * 	 - width: required if more than 250px
     * 	 - height: currently not used but may be needed in the future
     */
    public function __construct($name, $id_base = false, $widget_options = array(), $control_options = array()) {
        parent::__construct($id_base, $name, $widget_options, $control_options);
    }

    /**
     * Echo the widget content.
     * 
     * Subclasses should over-ride this function to generate their widget code.
     *
     * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
     * @param array $instance The settings for the particular instance of the widget
     */
    public abstract function widget($args, $instance);

    /**
     * Update a particular instance.
     * 
     * This function should check that $new_instance is set correctly.
     * The newly calculated value of $instance should be returned.
     * If "false" is returned, the instance won't be saved/updated.
     *
     * @param array $new_instance New settings for this instance as input by the user via form()
     * @param array $old_instance Old settings for this instance
     * @return array Settings to save or bool false to cancel saving
     */
    public abstract function update($new_instance, $old_instance);

    /**
     * Echo the settings update form
     *
     * @param array $instance Current settings
     */
    public abstract function form($instance);
}
