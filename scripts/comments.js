'use strict';

!function() {
    var ENDPOINT = '/api/comments';

    function makeComment(comment) {
        var div;
        var button;
        div = $('<div class="comment"></div>');
        div.append($('<span class="username"></span>').text(comment.username));
        div.append($('<span class="content"></span>').text(comment.content));
        if (comment.deletable) {
            button = $('<button class="delete-comment">Delete</button>');
            button.data('id', comment.id);
            button.on('click', onDeleteComment);
            div.append(button);
        }
        return div;
    }

    function setComments(comments) {
        $('#comments').empty().append($.map(comments, makeComment));
    }

    function onDeleteComment() {
        var comment = $(this);
        $.ajax(ENDPOINT, {
            type: 'DELETE',
            data: {id: comment.data('id')},
            success: function() {
                comment.closest('.comment').remove();
            }
        });
    }

    $(function() {
        $('#comment-form').submit(function() {
            var form = $(this);
            var content = form.find('.content').val();
            console.log(content);
            $.ajax(ENDPOINT, {
                type: 'POST',
                data: form.serialize(),
                success: function(res) {
                    $('#comments').append(makeComment({
                        id: res.id,
                        username: pagedata['username'],
                        content: content,
                        deletable: true
                    }));
                }
            });
            return false;
        });
    });

    $(document).on('login-state-changed', function() {
        $.ajax(ENDPOINT, {
            data: {'recipe-name': pagedata['recipe-name']},
            success: setComments
        });
    });
}();
