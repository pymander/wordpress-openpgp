/** Wrapper functions for OpenPGP.js

    These functions just help tie OpenPGP.js to some jQuery stuff so
    they can affect the DOM.
*/

/** Load a public key from a URI. The file at the end of the URI
    should just be an ASCII armored key file. */
function loadPublicKey(keyURI) {
    var response, publicKey;

    // We need this to be an asynchronous call.
    jQuery.ajax({
        url: keyURI,
        success: function (data) {
            publicKey = openpgp.key.readArmored(data);
        },
        dataType: 'html',
        async: false
    });

    return publicKey;
}

/** Encrypt a textarea. Pass in the id of a textarea and an
    openpgp.key object, maybe loaded by loadPublicKey() above. */
function encryptTextarea(textareaId, publicKey) {
    var area = jQuery('#' + textareaId);
    var plaintext;

    // If the browser can't do OpenPGP.js, we need to alert the user.
    if (!window.crypto.getRandomValues) {
        alert("We're sorry, but your browser doesn't support OpenPGP.js.");
        return false;
    }

    // If we didn't get a textareaId passed to us, find a suitable candidate and use that.
    if (!textareaId) {
        area = jQuery('#cryptbutton').parents('form').find('textarea');
        //alert("found area " + area);
    }

    // Finally, if we don't have an encryptable area at this point, let's bug out.
    if (!area) {
        alert("Unable to find encryptable textarea.");
        return false;
    }

    if (area.attr('data-encrypted')) {
        alert("You've already encrypted this textarea.");
        return false;
    }

    // Now, let's disable the textarea while we work.
    area.prop('readonly',true);

    // Fetch plaintext.
    plaintext = area.val();

    var pgpMessagePromise = openpgp.encryptMessage(publicKey.keys, plaintext);

    pgpMessagePromise.then(function (ctext) {
        // This initial newline makes sure the encrypted text starts on its own line.
        area.val("\n" + ctext);
        area.attr('data-encrypted', true);
    }, function (err) {
        alert(err);
    });

    // If you want to make the textarea writeable after, uncomment this.
    //area.prop('readonly',false);

    return true;
}

// Testing/staging
