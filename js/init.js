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
    var plaintext = jQuery('#' + textareaId).val();
    var encrypted = jQuery('#' + textareaId).attr('data-encrypted');

    if (encrypted) {
        alert("You've already encrypted this textarea.");
        return false;
    }

    var pgpMessage = openpgp.encryptMessage(publicKey.keys, plaintext);

    jQuery('#' + textareaId).val(pgpMessage);
    jQuery('#' + textareaId).attr('data-encrypted', true);

    return true;
}

// Testing/staging
