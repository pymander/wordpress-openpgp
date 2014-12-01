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

    Copyright 2014 Erik L. Arneson (email : earneson@arnesonium.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined('ABSPATH') or die("No script kiddies please!");

// This isn't actually being called all the time. We don't need to load all of the OpenPGP.js library on every
// page. It's too big for that.
function openpgp_enqueue_scripts () {
    wp_enqueue_script('openpgp', plugins_url('js/openpgp.min.js', __FILE__));
    wp_enqueue_script('openpgp-init', plugins_url('js/init.js', __FILE__));
}

function openpgp_cryptbutton_header ()
{
    $output = <<<EOT
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery(document).on('click', '.cryptbutton', function (event) {
        // Get textArea and public key info.
        var textareaId = jQuery(this).attr('data-textarea-id');
        var pubkeyUri = jQuery(this).attr('data-pubkey-uri');

        publicKey = loadPublicKey(pubkeyUri);
        encryptTextarea(textareaId, publicKey);
    });
});
</script>
EOT;

    echo $output;

}

function openpgp_cryptbutton_shortcode ($atts = array(), $content = null, $tag)
{
    // We load our JavaScript only if needed. It's a pretty hefty library.
    // Possible bug with this method: https://core.trac.wordpress.org/ticket/11526
    if (FALSE == wp_script_is('openpgp', 'enqueued')) {
        wp_enqueue_script('openpgp', plugins_url('js/openpgp.min.js', __FILE__));
        wp_enqueue_script('openpgp-init', plugins_url('js/init.js', __FILE__));
    }

    $args = shortcode_atts(
        array(
            'textarea' => null,
            'keyurl' => null,
            'keyid' => null,
            'class'  => null,
            'style' => null,
            'text'  => 'Encrypt'
        ),
        $atts
    );

    $keyurl = $args['keyurl'];

    // Easier is to just pass a media ID.
    if (0 < (int)$args['keyid']) {
        $keyurl = wp_get_attachment_url((int)$args['keyid']);
    }

    return sprintf("<button type=\"button\" class=\"cryptbutton %s\" %sdata-pubkey-uri=\"%s\" data-textarea-id=\"%s\">%s</button>",
                   $args['class'],
                   (isset($args['style']) ? "style=\"" . $args['style'] . "\" " : ''),
                   $keyurl,
                   $args['textarea'],
                   $args['text']
    );
}

// Set up stuff to print headers and things.
//add_action('wp_enqueue_scripts', 'openpgp_enqueue_scripts');
add_action('wp_head', 'openpgp_cryptbutton_header');
add_shortcode('cryptbutton', 'openpgp_cryptbutton_shortcode');
