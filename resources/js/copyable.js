$(document).ready(function () {
    $('.copyable').click(function(e) {
        e.preventDefault();

        navigator.clipboard.writeText($(this).data("clipboard-text")).then(function() {
            alert("Copied to clipboard!")
        }, function() {
            alert("Data could not be copied to clipboard.")
        });
    });
});