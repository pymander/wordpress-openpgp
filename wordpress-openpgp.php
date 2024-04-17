<?php
/**
 * @package OpenPGP
 */
/*
Plugin Name: OpenPGP for Textareas
Description: Provide encryption using OpenPGP.js for textareas via buttons and callbacks and such.
Version: 1.5.1
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

define('OPENPGP_VERSION', '2.6.1');

// This isn't actually being called all the time. We don't need to load all of the OpenPGP.js library on every
// page. It's too big for that.
function openpgp_enqueue_scripts () {
    if (FALSE == wp_script_is('openpgp', 'enqueued')) {
        wp_enqueue_script('openpgp', plugins_url('js/openpgp.' . OPENPGP_VERSION . '.min.js', __FILE__));
        wp_enqueue_script('openpgp-init', plugins_url('js/init.js', __FILE__));
    }
}

function openpgp_cryptbutton_header ()
{
    $output = <<<EOT
<script type="text/javascript">
var openpgpWorkerUri = 'WORKER_URI';
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

    $output = str_replace('WORKER_URI', plugins_url('js/openpgp.worker.' . OPENPGP_VERSION . '.min.js', __FILE__), $output);

    echo $output;

}

function openpgp_cryptbutton_shortcode ($atts = array(), $content = null, $tag)
{
    openpgp_enqueue_scripts();

    $args = shortcode_atts(
        array(
            'textarea' => null,
            'keyurl' => null,
            'keyid' => null,
            'class'  => null,
            'text'  => 'Encrypt'
        ),
        $atts
    );

    return openpgp_cryptbutton_create($args, $content, $tag);
}

function openpgp_cryptbutton_wpcf7 ($tag) {
    openpgp_enqueue_scripts();

    //$tag = new WPCF7_Shortcode( $tag );

    $args = array(
        'textarea' => $tag->get_option('textarea', 'id', true),
        'keyurl' => $tag->get_option('keyurl', '.*', true),
        'keyid' => $tag->get_option('keyid', 'int', true),
        'class' => $tag->get_class_option(),
        'text' => $tag->values[0]
    );

    return openpgp_cryptbutton_create ($args);
}

function openpgp_cryptbutton_create ($args, $content = null, $tag = null) {
    
    $keyurl = $args['keyurl'];

    // Easier is to just pass a media ID.
    if (0 < (int)$args['keyid']) {
        $keyurl = wp_get_attachment_url((int)$args['keyid']);
    }

    // Let's make sure we're using the right content.
    if (null == $content) {
        $content = $args['text'];
    }

    return sprintf("<button type=\"button\" id=\"cryptbutton\" class=\"cryptbutton %s\" data-pubkey-uri=\"%s\"%s>%s</button>",
                   esc_attr($args['class']),
                   esc_url($keyurl),
                   (isset($args['textarea']) ?  " data-textarea-id=\"" . esc_attr($args['textarea']) . "\"" : ''),
                   esc_html($content)
    );
}

// Set up stuff to print headers and things.
//add_action('wp_enqueue_scripts', 'openpgp_enqueue_scripts');
add_action('wp_head', 'openpgp_cryptbutton_header');
add_shortcode('cryptbutton', 'openpgp_cryptbutton_shortcode');

// If Contact Form 7 is installed, we can do this, too.
add_action('wpcf7_init', function () {
    wpcf7_add_form_tag('cryptbutton', 'openpgp_cryptbutton_wpcf7');
    //wpcf7_add_shortcode('cryptbutton', 'openpgp_cryptbutton_wpcf7', false);
});

