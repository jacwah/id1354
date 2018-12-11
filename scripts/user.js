'use strict';

!function() {
    function loggedIn(username) {
        var loggedIns = $('.logged-in');
        var loggedOuts = $('.logged-out');
        if (username) {
            $('#logout-button').text('Logout (' + username + ')');
            loggedIns.show();
            loggedOuts.hide();
        } else {
            loggedIns.hide();
            loggedOuts.show();
        }
        $(document).trigger('login-state-changed', username);
    }

    $(function() {
        loggedIn(pagedata['initial-username']);

        $('#login-form').submit(function() {
            var form = $(this);
            $.post('/api/login', form.serialize(), function(res) {
                loggedIn(res.username);
            });
            return false;
        });

        $('#logout-button').on('click', function() {
            $.post('/api/logout', undefined, function() {
                loggedIn(null);
            });
            return false;
        });
    });
}();
