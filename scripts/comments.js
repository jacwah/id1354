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
        $('#comment-form').on('af-success', function(event, res) {
            $('#comments').append(makeComment({
                id: res.id,
                username: username,
                content: $(this).find('.content').val(),
                deletable: true
            }));
        });

        $('#comments').on('click', '.delete-comment', function() {
            var button = $(this);
            $.ajax(ENDPOINT, {
                type: 'DELETE',
                data: {id: button.data('id')},
                success: function() {
                    button.closest('.comment').remove();
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
