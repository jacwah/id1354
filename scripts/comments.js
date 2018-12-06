'use strict';

!function() {
    function setComments(comments) {
        var commentsEl;
        var comment;
        var oldEl;
        var divEl;
        var usernameEl;
        var contentEl;
        var deleteEl;

        commentsEl = document.getElementById('comments');

        while (commentsEl.firstChild)
            commentsEl.removeChild(commentsEl.firstChild);

        for (comment of comments) {
            divEl = document.createElement('div');
            usernameEl = document.createElement('span');
            contentEl = document.createElement('span');
            divEl.className = 'comment';
            divEl.appendChild(usernameEl);
            divEl.appendChild(contentEl);
            usernameEl.className = 'username';
            usernameEl.innerHTML = comment.username;
            contentEl.className = 'content';
            contentEl.innerHTML = comment.content;
            if (comment.deletable) {
                deleteEl = document.createElement('button');
                deleteEl.className = 'delete-comment';
                deleteEl.innerHTML = 'Delete';
                deleteEl.addEventListener('click', onDeleteComment);
                deleteEl.dataset.id = comment['id'];
                divEl.appendChild(deleteEl);
            }
            commentsEl.appendChild(divEl);
        }
    }

    function onDeleteComment(event) {
        var req;

        req = new XMLHttpRequest();
        req.open('DELETE', '/api/comments');
        req.send(JSON.stringify({id: this.dataset.id}));
        this.parentNode.parentNode.removeChild(this.parentNode);
    }

    function onPostComment(event) {
    }

    function getComments() {
        var req;
        var data;

        req = new XMLHttpRequest();
        req.open('GET', '/api/comments?recipe-name=' + pagedata['recipe-name']);
        req.addEventListener('load', function() {
            if (req.status === 200) {
                console.log(req.responseText);
                setComments(JSON.parse(req.responseText));
            } else {
                console.log(req.status, req.responseText);
            }
        });
        req.send();
    }

    document.addEventListener('login-state-changed', function(event) {
        getComments();
    });
}();
