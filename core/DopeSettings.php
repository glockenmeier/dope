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
 * @link http://codex.wordpress.org/Settings_API Settings API
 */
class DopeSettings {
    /**
     *
     * @var DopeSettingsSection
     */
    protected $sections = array();
    protected $page;
    private $page_title;
    private $menu_title;
    private $capability;
    
    /*
     * Settings corresponds to one settings page.
     * A page has sections, each section has fields.
     * One way would be to populate Settings with sections, which
     * has fields.
     * In WP, each field has a callback. Check if we could use
     * a single callback per section. Section has callback to just
     * to display a description or other things.
     * 
     * For each settings in WP we need to use register_setting
     * with section and field name as parameter. We can hide this detail.
     * 
     * There are a lot of details which we can hide under DopeSettings.
     * Repetitive, error prone ordering etc..
     * 
     * Ideally: DopeSettings.addSection(Section)
     *          DopeSettings.callback() handles section and fields, so we can
     *          insert view on function.
     *          DopeSection.addField(Field)
     *          
     * finish settings by calling register() and DopeSettings do all the work.
     */
    
    public function __construct($page) {
        $this->page = $page;
    }
    
    public function addOptionsPage($page_title, $menu_title, $capability = 'manage_options') {
        $this->page_title = $page_title;
        $this->menu_title = $menu_title;
        $this->capability = $capability;
        add_action('admin_menu', array($this, '_doAddOptionsPage'));
    }
    
    public function _doAddOptionsPage() {
        add_options_page($this->page_title, $this->menu_title, 
                $this->capability, $this->page, array($this, '_doRenderPage'));
        
    }
    
    public function _doRenderPage() {
        $view = new SimpleDopeView(DGOOPlugin::getInstance()->getDirectory());
        $view->assign("page", $this->page)
                ->assign("page_title", $this->page_title)
                ->assign("option_group", $this->page)
                ->render('template/options-page');
        
    }
    
    public function addSection(DopeSettingsSection $section) {
        if (array_key_exists($section->getTitle(), $this->sections))
                return false;
        array_push($this->sections, $section);
        return true;
    }
    
    public function removeSection(DopeSettingsSection $section) {
        if (!array_key_exists($section->getTitle(), $this->sections))
                return false;
        
        unset($this->fields[$section->getTitle()]);
    }
    
    public function getFields() {
        return $this->fields;
    }
    
    public function register() {
        add_action('admin_init', array($this, '_doRegister'));
    }
    
    
    
    public function _doRegister() {
        $section_it = new DopeArrayIterator($this->sections);        
        // register sections
        while ($section_it->hasNext()) {
            $section = $section_it->next();
            if ($section instanceof DopeSettingsSection === false){
                continue;
            }
            add_settings_section($section->getName(), $section->getTitle() ,$section->getCallback(), $this->page);

            $field_it = new DopeArrayIterator($section->getFields());
            // register fields
            while ($field_it->hasNext()) {
                $field = $field_it->next();
                if ($field instanceof DopeSettingsField === false){
                    continue;
                }
                add_settings_field($field->getOption(), $field->getDescription(), $field->getCallback(), $this->page, $section->getName());

                // Register our setting so that $_POST handling is done
                // for us and our callback function just has to echo
                // the input
                register_setting($this->page, $field->getOption());
            }
        }
    }
}
