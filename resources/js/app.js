require('./bootstrap');

$('.custom-file-input').on('change',function(){
    var names = [];
    for (var i = 0; i < $(this).get(0).files.length; i++) {
        names.push($(this).get(0).files[i].name.replace('C:\\fakepath\\', ''));
    }
    $(this).next('.custom-file-label').html(names.join(", "));
})

callDelete = function (elementId, url, token) {
    $.ajax({
        type: 'delete',
        data: {
            _token: token
        },
        url: url
    }).done(response => {
        const parent = $(elementId).parent();  

        $(elementId).remove();
        if (parent.children().length == 0) {
            if (parent.parent().attr("on-remove-display")) {
                $(parent.parent().attr("on-remove-display")).toggleClass('d-none');
            }
            parent.parent().remove();
        }
    });
}

$('.sortable').sortable({
    placeholder: 'sort-highlight',
    handle: '.handle',
    forcePlaceholderSize: true,
    zIndex: 999999,
    stop: function(event, ui) {
        var elements = []
        $(event.target).children().each(function() { elements.push(this.id); });
        $.ajax({
            type: 'PUT',
            data: {
                _token: $(event.target).data("token"),
                elements: elements
            },
            url: $(event.target).data("sortable-url")
        });
    }
});

$('#modal-remove,#modal-list').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    $('.modal-title', this).html(button.data("title"));
    $('.modal-body', this).html(button.data("body"));

    if (button.data('callback')) {
        $(this).data("callback", button.data('callback'));
    } else if(button.data("url")) {
        $("form", this).attr("action", button.data("url"));
    }
});
$("#modal-remove [data-proceed]").on('click', function(event) {
    const modal = $(this).closest('#modal-remove');
    if (modal.data('callback')) {
        eval(modal.data('callback'));
    }
    modal.modal('hide');
});

Inputmask().mask(document.querySelectorAll("input"));