<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Provides plugin information retrieved from metadata file.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @property-read string $bootstrapFile Bootstrap file path
 * @property-read array $plugin_data Raw plugin data retrievd by {@see get_plugin_data}
 * @uses get_plugin_data Used to read plugin-metadata
 */
class DopePluginInfo {

    private $bootstrapFile;
    private $plugin_data;

    /**
     * Creates a new instance of DopePluginInfo
     * @param DopePlugin $plugin plugin instance to get meta-data from
     * @param string $plugin_file Optional. will use the specified file to read meta-data instead of the one supplied by $plugin.
     */
    public function __construct(DopePlugin $plugin = null, $plugin_file = null) {
        
        $this->bootstrapFile = $plugin !== null ? $plugin->bootstrapFile : $plugin_file;
        
        if (true == false){
            $this->plugin_data = get_plugin_data($this->bootstrapFile, true, true);
        } else {
            $default_headers = array(
		'Name' => 'Plugin Name',
		'PluginURI' => 'Plugin URI',
		'Version' => 'Version',
		'Description' => 'Description',
		'Author' => 'Author',
		'AuthorURI' => 'Author URI',
		'TextDomain' => 'Text Domain',
		'DomainPath' => 'Domain Path',
		'Network' => 'Network',
		// Site Wide Only is deprecated in favor of Network.
		'_sitewide' => 'Site Wide Only',
            );
            $this->plugin_data = get_file_data($this->bootstrapFile, $default_headers);
        }
    }
    
    /**
     * Parse the plugin contents to retrieve plugin's metadata.
     * @param type $plugin_file Path to the plugin file
     * @return DopePluginInfo new instance of DopePluginInfo
     * @uses get_plugin_data to parse the plugin file directly
     */
    public static function fromPluginFile($plugin_file) {
        return new DopePluginInfo(null, $plugin_file);
    }
    
    /**
     * Uses plugin supplied bootstrap file to retrieve plugin's metadata.
     * @param DopePlugin $plugin DopePlugin object
     * @return DopePluginInfo new instance of DopePluginInfo
     */
    public static function fromPlugin(DopePlugin $plugin) {
        return new DopePluginInfo($plugin);
    }

    /**
     * Gets the class properties, also looks for plugin metadata using {@see get}.
     * @param property $property property name
     * @return mixed property value
     * @uses get search in plugin metadata in addition to class properties
     * @throws Exception on unknown property.
     */
    public function __get($property) {
        switch ($property) {
            case "bootstrapFile":
                return $this->bootstrapFile;
                break;
            case "plugin_data":
                return $this->plugin_data;
                break;
            default:
                $value = $this->get($property);
                if ($value === null) {
                    throw new Exception('Unknown property: ' + $property);
                }
                return $value;
        }
    }

    /**
     * Gets plugin meta-data value by the meta-key.
     * Usefull if you have a custom plugin metadata.
     * @param type $property
     * @return mixed|null plugin meta-data value. or null if meta-data does not exists.
     */
    public function get($property) {
        if (isset($this->plugin_data[$property])) {
            return $this->plugin_data[$property];
        }
        return null;
    }

    /**
     * Name of the plugin, must be unique.
     * @return string
     */
    public function getName() {
        return $this->get('Name');
    }
    
    /**
     * Title of the plugin and the link to the plugin's web site.
     * @return string
     */
    public function getTitle() {
        return $this->get('Title');
    }
    
    /**
     * Description of what the plugin does and/or notes from the author.
     * @return string
     */
    public function getDescription() {
        return $this->get('Description');
    }
    
    /**
     * The author's name
     * @return string
     */
    public function getAuthor() {
        return $this->get('Author');
    }
    
    /**
     * The authors web site address.
     * @return string
     */
    public function getAuthorURI() {
        return $this->get('AuthorURI');
    }
    
    /**
     * The plugin version number.
     * @return string
     */
    public function getVersion() {
        return $this->get('Version');
    }
    
    /**
     * Plugin web site address.
     * @return string
     */
    public function getPluginURI() {
        return $this->get('PluginURI');
    }
    
    /**
     * Plugin's text domain for localization.
     * @return string
     */
    public function getTextDomain() {
        return $this->get('TextDomain');
    }
    
    /**
     * Plugin's relative directory path to .mo files.
     * @return string
     */
    public function getDomainPath() {
        return $this->get('DomainPath');
    }
    
    /**
     * Boolean. Whether the plugin can only be activated network wide.
     * @return boolean true if only plugin can only be activated network wide on a multisite.
     */
    public function getNetwork() {
        return filter_var($this->get('Network'), FILTER_VALIDATE_BOOLEAN);
    }
}
