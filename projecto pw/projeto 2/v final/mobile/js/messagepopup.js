function messagePopup(message) {
    $("<div class='ui-loader ui-overlay-shadow ui-body-b ui-corner-all'><h1>" + message + "</h1></div>")
        .css({
            display: "block",
            opacity: 0.96,
            top: window.pageYOffset+100
        })
        .appendTo("body").delay(800)
        .fadeOut(400, function(){
            $(this).remove();
        });
}
