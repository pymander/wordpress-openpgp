<?php
/**
 * @package OpenPGP
 */
/*
Plugin Name: OpenPGP for Textareas
Description: Provide encryption using OpenPGP.js for textareas via buttons and callbacks and such.
Version: 0.1
Author: Erik L. Arneson
Author URI: http://www.arnesonium.com/
License: GPLv2 or later
*/

wp_enqueue_script('openpgp', plugins_url('js/openpgp.min.js', __FILE__));
