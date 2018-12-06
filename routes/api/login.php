<?php
use \TastyRecipes\Controller\LoginController;
use \TastyRecipes\Controller\UserController;
use \TastyRecipes\View\HttpSession;
use \TastyRecipes\View\Http;
use \TastyRecipes\Integration\UserNotFoundException;

if (!$user_cntr->loggedIn()) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        try {
            $login_cntr = new LoginController($_POST['username'], $_POST['password']);
            $http_session = HttpSession::create();
            $login_cntr->saveSession($http_session->getId());
            $user_cntr = new UserController();
            $user_cntr->authenticate($http_session->getId());
        } catch (UserNotFoundException $e) {
        }
    }
}

if ($user_cntr->loggedIn()) {
    echo $user_cntr->getUser()->getName();
} else {
    http_response_code(Http::FORBIDDEN);
}
