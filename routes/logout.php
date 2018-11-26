<?php
use \TastyRecipes\View\Http;
use \TastyRecipes\View\HttpSession;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user_cntr->loggedIn())
        $user_cntr->logout();
    if (isset($http_session))
        $http_session->kill();
    $ctx->set('current_user', null);
    $ctx->set('page_name', 'Login');
    $ctx->set('success', 'Logged out');
    $ctx->render('login-form');
} else {
    http_response_code(HTTP_METHOD_NOT_ALLOWED);
}
