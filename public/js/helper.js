/* Global Helper Functions */

/* Generate flash message from javascript */
function flash(type, msg, delay) {
    var el = $("div.js-flash-message");

    if (el) {
        el.remove();
    }

    $("<div></div>", {
        "class": "alert alert-" + type + " alert-dismissible js-flash-message",
        "html": '<button type="button" class="close" data-dismiss="alert">' +
            '<span aria-hidden="true">&times;</span>' +
            '<span class="sr-only">Close</span></button>' + msg
    }).appendTo($(".container").first());

    $("div.js-flash-message").fadeIn("fast").delay(delay || 5000).fadeOut("fast");
}

/* Reload page */
function reload(interval) {
    setTimeout(function () {
        window.location.reload(true);
    }, interval || 5000);
}