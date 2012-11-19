<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * Description of DopePluginsModel
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-oo-plugin-internal
 * @subpackage model
 * @internal DOPE's MVC Model
 * @access private
 */
class DopePluginsModel {

    public function disableDopePlugins() {
        $plugins = $this->getPlugins();
        array_reverse($plugins);
        $dope = DGOOPlugin::getInstance(null);
        foreach ($plugins as $p) {
            $this->deactivateDopePlugin($p['bootstrapFile'], false, null);
        }
        $this->deactivateDopePlugin($dope->bootstrapFile);
    }

    public function deactivateDopePlugin($bootstrapFile) {
        if (!is_array($bootstrapFile)){
            $bootstrapFile = array( $bootstrapFile );
        }
        deactivate_plugins($bootstrapFile);
    }

    public function activateDopePlugin($bootstrapFile) {
        activate_plugin($bootstrapFile);
    }

    public function activateDopePlugins(array $bootstrapFiles) {
        activate_plugins($bootstrapFiles);
    }

    /**
     * Array with K/V pairs.
     * @return array
     */
    public function getPlugins($includeSelf = false) {
        $pm = DopePluginManager::getInstance();
        $result = array();
        $plugins = $pm->getPlugins();
        foreach ($plugins as $p) {
            if ($p->getName() === "dope" && !$includeSelf)
                continue;

            if ($p instanceof DopePluginInfo) {
                $result[] = array(
                    "name" => esc_html($p->getName()),
                    "description" => $this->sanitizeDescriptionHtml($p->getDescription()),
                    "bootstrapFile" => $p->bootstrapFile);
            }
        }
        return $result;
    }

    private function sanitizeDescriptionHtml($text) {
        $allowedHtml = array(
            'a' => array('href' => array(), 'title' => array()),
            'strong' => array(),
            'br' => array()
        );
        return wp_kses($text, $allowedHtml);
    }

}
