<?php

/**
 * Contains utility fungtions which doesn't fit anywhere else
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package dg-oo-plugin
 * @subpackage core
 */
class DopeUtil {

    private function __construct() {
        // non instantiable
    }

    /**
     * Safely cleans the output buffer without worrying if there are any content in the buffer or if it's deactivated.
     * @return string|null the content that gets cleaned or null if there aren't any.
     */
    public static function ob_safe_clean() {
        $contents = ob_get_contents();
        if ($contents !== false || strlen($contents) > 0) {
            $contents = ob_clean();
            return $contents;
        }
        return null;
    }
    
    /**
     * Check if the installed dope is compatible with the required dope version
     * @param type $required_dope_version the version number of dope required
     * @return boolean true only if dope version is equal or greater than the required version
     */
    public static function check_version($required_dope_version){
        return version_compare(DOPE_PLUGIN_VERSION, $required_dope_version) >= 0;
    }

}

?>
