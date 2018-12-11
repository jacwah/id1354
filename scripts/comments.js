'use strict';

!function() {
    var ENDPOINT = '/api/comments';
    var username;

    function makeComment(comment) {
        var div;
        var button;
        div = $('<div class="comment"></div>');
        div.append($('<span class="username"></span>').text(comment.username));
        div.append($('<span class="content"></span>').text(comment.content));
        if (comment.deletable) {
            button = $('<button class="delete-comment">Delete</button>');
            button.data('id', comment.id);
            div.append(button);
        }
        return div;
    }

    function setComments(comments) {
        $('#comments').empty().append($.map(comments, makeComment));
    }

    $(function() {
        $('#comment-form').submit(function() {
            var form = $(this);
            var content = form.find('.content');
            var button = form.find(':submit');
            button.prop('disabled', true);
            $.ajax(ENDPOINT, {
                type: 'POST',
                data: form.serialize(),
                success: function(res) {
                    $('#comments').append(makeComment({
                        id: res.id,
                        username: username,
                        content: content.val(),
                        deletable: true
                    }));
                    button.prop('disabled', false);
                    content.val('');
                }
            });
            return false;
        });

        $('#comments').on('click', '.delete-comment', function() {
            var comment = $(this);
            $.ajax(ENDPOINT, {
                type: 'DELETE',
                data: {id: comment.data('id')},
                success: function() {
                    comment.closest('.comment').remove();
                }
            });
        });
    });

    $(document).on('login-state-changed', function(event, newUsername) {
        username = newUsername;
        $.ajax(ENDPOINT, {
            data: {'recipe-name': pagedata['recipe-name']},
            success: setComments
        });
    });
}();
