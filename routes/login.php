<?php
use \TastyRecipes\Controller\LoginController;
use \TastyRecipes\Controller\UserController;
use \TastyRecipes\View\HttpSession;
use \TastyRecipes\Integration\UserNotFoundException;

if ($user_cntr->loggedIn()) {
    $ctx->render('logged-in');
} else {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        try {
            $login_cntr = new LoginController($_POST['username'], $_POST['password']);
            $http_session = HttpSession::create();
            $login_cntr->saveSession($http_session->getId());
            $user_cntr = new UserController();
            $user_cntr->authenticate($http_session->getId());
            $ctx->set('user_cntr', $user_cntr);
            $ctx->render('logged-in');
            die();
        } catch (UserNotFoundException $e) {
            $ctx->set('error', 'Wrong username or password');
        }
    }
    $ctx->render('login-form');
}
