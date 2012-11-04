<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Provides plugin information such as name, description, etc.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 * @property-read string $name Plugin name
 * @property-read string $description Plugin description
 * @property-read string $bootstrapFile Bootstrap file path
 */
class DopePluginInfo {
    private $name;
    private $description;
    private $bootstrapFile;
    public function __construct(DopePlugin $plugin) {
        $this->name = $plugin->getName();
        $this->description = $plugin->getDescription();
        $this->bootstrapFile = $plugin->bootstrapFile;
    }
    
    /**
     * 
     * @param type $property
     * @return type
     * @throws Exception
     */
    public function __get($property) {
    switch ($property) {
      case "name":
        return $this->name;
      case "description":
        return $this->description;
      case "bootstrapFile":
        return $this->bootstrapFile;
        break;
      default:
        throw new Exception("Unknown property: " . $property);
    }
  }
}
