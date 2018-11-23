<?php
use \TastyRecipes\Controller\LoginController;
use \TastyRecipes\Controller\UserController;
use \TastyRecipes\View\HttpSession;
use \TastyRecipes\Integration\UserNotFoundException;

if ($user_cntr) {
    require 'views/logged-in.php';
    die();
} else if ($_POST['username'] && $_POST['password']) {
    try {
        $login_cntr = new LoginController($_POST['username'], $_POST['password']);
        $http_session = HttpSession::create();
        $login_cntr->saveSession($http_session->getId());
        $user_cntr = new UserController($http_session->getId());

        require 'views/logged-in.php';
        die();
    } catch (UserNotFoundException $e) {
        $error = 'Wrong username or password';
    }
}

require 'views/login-form.php';
