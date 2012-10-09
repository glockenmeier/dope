<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of PluginInfo
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-oo-plugin
 * @subpackage core
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
    
    public function __get($property) {
    switch ($property) {
      case "name":
        return $this->name;
        break;
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

?>
