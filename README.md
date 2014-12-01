OpenPGP Form Encryption for WordPress
=====================================

This plugin uses [OpenPGP.js](http://openpgpjs.org/) to provide public key encryption for a
textarea. It is most useful for any kind of text area that will be
submitted via email or over an unsecured network connection.

# Installation
To install this plugin, follow these directions:

1. Download the latest zip file from [the releases page](https://github.com/pymander/wordpress-openpgp/releases).
1. Next, load up your WordPress blog’s dashboard, and go to **Plugins > Add New**.
1. Upload the zip file.
1. Click **Activate**.

# Usage

OpenPGP for WordPress requires access to an OpenPGP public key in
ASCII armored form. For more information on key generation and
OpenPGP, I recommend the [Email Self-Defense website](https://emailselfdefense.fsf.org/en/), which has
instructions for multiple operating systems.

## The `cryptbutton` Shortcode

This plugin provides a simple shortcode which you can add to your
forms. To use the shortcode, you must first upload your ASCII-armored
public key to your blog’s media section. Note that the public key must
reside on the same server as your blog.

The `cryptbutton` shortcode takes the following arguments.

**keyid**
The media ID of your ASCII-armored public key. Either this or keyurl
are required.

**keyurl**
The URL for your ASCII-armored public key. Either this argument or
keyid are required.

**textarea**
The HTML ID for the textarea element to be encrypted. This argument is
required.

**class**
Optional. Specify additional CSS classes for the button element.

**style**
Optional. Specify additional CSS styles for the button element.

**text**
Optional. Specify the button text. This defaults to “Encrypt”.

## Example

I use this plugin with the [Jetpack for WordPress](http://jetpack.me/) contact form. You can
see an example of the output on my [Contact page](http://arnesonium.com/contact/). The WordPress code
looks something like this:

```
[contact-form subject='ARNESONIUM CONTACT']
[contact-field label='Name' type='name' required='1'/]
[contact-field label='Email' type='email' required='1'/]
[contact-field label='Phone' type='text'/]
[contact-field label='Comment' type='textarea' required='1'/]
[cryptbutton textarea="contact-form-comment" keyid=42]
[/contact-form]
```

Line 6 displays the cryptbutton usage. Note that I changed some
elements of this example to make things clearer. You will need to play
with layout and CSS to get things looking nice.

# Support

For support and bug reports, please visit the GitHub project page.

# Acknowledgements

This plugin uses OpenPGP.js, which can be found here: http://openpgpjs.org/

A version is included with the plugin so that this software doesn't
have to worry about API changes and so that end users don't have to
worry about downloading multiple pieces of software.
