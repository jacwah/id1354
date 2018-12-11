'use strict';

$(function() {
    function showError(form, msg) {
        form.prepend($('<div class="status-error"></div>').text(msg));
    }

    $(document).on('submit', 'form.ajax-form', function() {
        var form = $(this);
        var submit = form.find(':submit');
        submit.prop('disabled', true);
        form.find('.status-error').remove();
        $.ajax(form.data('action'), {
            type: 'POST',
            data: form.serialize(),
            complete: function() {
                submit.prop('disabled', false);
            },
            success: function(res) {
                form.trigger('af-success', res);
                form.find('.af-clear').val('');
            },
            statusCode: {
                422: function(xhr) {
                    var msg;
                    if (xhr.responseJSON && xhr.responseJSON.error)
                        msg = xhr.responseJSON.error;
                    else
                        msg = 'Please try again later';
                    showError(form, msg);
                }
            }
        });
        return false;
    });
});

