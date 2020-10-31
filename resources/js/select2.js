require('select2');

$('[multiple]').each(function(){
    if ($(this).hasClass("tags")) {
        $(this).select2({
            theme: "bootstrap4",
            placeholder: $(this).attr('data-placeholder'),
            allowClear: false,
            tags: true,
        });
    }
    else {
        $(this).select2({
            theme: "bootstrap4",
            placeholder: $(this).attr('data-placeholder'),
            allowClear: false,
        });
    }
});

$('.tr-search-input').each(function() {
    $(this).select2({
        theme: "bootstrap4",
        allowClear: false,
        tags: true,
    });
    $('b[role="presentation"]').hide();
});