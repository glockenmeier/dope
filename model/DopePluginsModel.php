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
 */
class DopePluginsModel {

    public function disableDopePlugins() {
        $plugins = $this->getPlugins();
        $dope = DGOOPlugin::getInstance(null);
        foreach ($plugins as $p) {
            deactivate_plugins($p['bootstrapFile']);
        }
        // deactivate dope itself
        deactivate_plugins($dope->bootstrapFile);
    }

    public function deactivateDopePlugin($bootstrapFile) {
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
            if ($p->name === "dope" && !$includeSelf)
                continue;

            if ($p instanceof DopePluginInfo) {
                $result[] = array(
                    "name" => esc_html($p->name),
                    "description" => $this->sanitizeDescriptionHtml($p->description),
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
