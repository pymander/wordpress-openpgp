=== OpenPGP Form Encryption for WordPress ===
Contributors: arnesonium
Tags: forms, encryption, pgp, gnupg, openpgp
Requires at least: 4.0
Tested up to: 4.2.2
Stable tag: v1.3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RXC68YPEATPUU

OpenPGP public key encryption for any textarea with a shortcode button.

== Description ==

This plugin uses [OpenPGP.js](http://openpgpjs.org/) to provide public key encryption for a
textarea. It is most useful for any kind of text area that will be
submitted via email or over an unsecured network connection.

The GitHub repository for this plugin is located at https://github.com/pymander/wordpress-openpgp

= Usage =
This plugin provides a simple shortcode which you can add to your
forms. To use the shortcode, you must first upload your ASCII-armored
public key to your blog’s media section. Note that the public key must
reside on the same server as your blog.

The `cryptbutton` shortcode takes the following arguments.

**keyid**
The media ID of your ASCII-armored public key. Either this or `keyurl`
are required.

**keyurl**
The URL for your ASCII-armored public key. Either this argument or
`keyid` are required.

**textarea** 
Optional. The HTML ID for the textarea element to be encrypted. When
this is omitted, the plugin will try to find the correct textarea
automatically.

**class**
Optional. Specify additional CSS classes for the button element.

**style**
Optional. Specify additional CSS styles for the button element.

**text**
Optional. Specify the button text. This defaults to "Encrypt". You can
also use the shortcode as an open/close tag, and the contents will be
used as the button text.

= Example =

I use this plugin with the [Jetpack for WordPress](http://jetpack.me/) contact form. You can
see an example of the output on my [Contact page](http://arnesonium.com/contact/). The WordPress code
looks something like this:

    [contact-form subject='ARNESONIUM CONTACT']
    [contact-field label='Name' type='name' required='1'/]
    [contact-field label='Email' type='email' required='1'/]
    [contact-field label='Phone' type='text'/]
    [contact-field label='Comment' type='textarea' required='1'/]
    [cryptbutton keyid=42]Encrypt[/cryptbutton]
    [/contact-form]

Line 6 displays the cryptbutton usage. Note that I changed some
elements of this example to make things clearer. You will need to play
with layout and CSS to get things looking nice.


== Installation ==

To install this plugin, follow these directions:

1. Download the latest zip file from [the releases page](https://github.com/pymander/wordpress-openpgp/releases).
1. Next, load up your WordPress blog’s dashboard, and go to **Plugins > Add New**.
1. Upload the zip file.
1. Click **Activate**.

== Frequently Asked Questions ==

= How do I get a public key? =

OpenPGP for WordPress requires access to an OpenPGP public key in
ASCII armored form. For more information on key generation and
OpenPGP, I recommend the [Email Self-Defense website](https://emailselfdefense.fsf.org/en/), which has
instructions for multiple operating systems.

== Screenshots ==

1. A textarea that has been encrypted, including a view of the "Encrypt" button.

== Changelog ==
= 1.3.0 =
* Update to OpenPGP.js 1.0.1
* Tested against WordPress 4.2.2
* Robust checks to make sure the browser can support OpenPGP.js

= 1.2 =
* Automatically find textarea for encryption.
* Fixed possible bug with plaintext modification.
* Use open and close tags for custom button text.

= 1.1 =
* Prepare everything for inclusion in WordPress Plugin repository.

= 1.0 =
* First release.

= 0.9 =
* Development pre-release.

== Upgrade Notice ==

There is no pressing need to upgrade to the latest version. If you're
on at least version 1.0, everything should be just dandy for you.

