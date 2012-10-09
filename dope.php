<?php
/**
 * Plugin Name: DG's Object-oriented Plugin Extension
 * Provides:    dope
 * Plugin URI:  http://www.baliashram.com/
 * Description: Add's an object oriented plug-in layer for WordPress.
 * Version:     0.1.6
 * Author:      Darius Glockenmeier
 * Author URI:  http://www.baliashram.com/
 * Network:     true
 * License:     GPLv3
 */

/* Copyright (C) 2012  Darius Glockenmeier

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once 'dope-autoload.php';

$dope_version = "0.1.4";

define('DOPE_PLUGIN', "DG's Object-oriented Plugin extension v" + $dope_version);
define('DOPE_PLUGIN_VERSION', $dope_version);
define('DOPE_BASENAME', plugin_basename(__FILE__));

DGOOPlugin::init(__FILE__);
