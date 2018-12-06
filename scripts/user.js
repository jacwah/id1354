'use strict';

!function() {
    var loggedInLink;
    var loggedOutLink;
    var loginButtonEl;
    var logoutButtonEl;

    function sendLogin(loginData) {
        var req;

        req = new XMLHttpRequest();
        req.open('POST', '/api/login');
        req.addEventListener('load', function() {
            if (req.status === 200) {
                loggedIn(req.responseText);
            } else if (req.status === 403) {
                loginError('Wrong username or password');
            } else {
                console.log(req.status, req.responseText);
            }
        });
        req.send(loginData);
    }

    function sendLogout() {
        var req;

        req = new XMLHttpRequest();
        req.open('POST', '/api/logout');
        req.addEventListener('load', function() {
            if (req.status === 200) {
                loggedIn(null);
            } else {
                console.log(req.status, req.responseText);
            }
        });
        req.send(null);
    }

    function loggedIn(username) {
        if (username) {
            logoutButtonEl.innerHTML = 'Logout (' + username + ')';
            loggedInLink.disabled = false;
            loggedOutLink.disabled = true;
        } else {
            loggedInLink.disabled = true;
            loggedOutLink.disabled = false;
        }
    }

    document.addEventListener('DOMContentLoaded', function(event) {
        var userEl = document.querySelector("meta[name='username']");
        var username = null;

        loggedInLink = document.getElementById('logged-in-link');
        loggedOutLink = document.getElementById('logged-out-link');
        loginButtonEl = document.getElementById('login-button');
        logoutButtonEl = document.getElementById('logout-button')

        if (userEl)
            username = userEl.getAttribute('content');
        loggedIn(username);

        loginButtonEl.addEventListener('click', function(event) {
            var loginData = new FormData();
            for (var input of document.querySelectorAll('#login>input')) {
                loginData.set(input.getAttribute('name'), input.value);
            }
            sendLogin(loginData);
        });

        logoutButtonEl.addEventListener('click', function(event) {
            sendLogout();
        });
    });
}();
