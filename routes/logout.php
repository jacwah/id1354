<?php
use \TastyRecipes\View\Http;
use \TastyRecipes\View\HttpSession;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user_cntr->loggedIn())
        $user_cntr->logout();
    if (isset($http_session))
        $http_session->kill();
    $ctx->set('page_name', 'Logged out');
    $ctx->set('logged_out', TRUE);
    $ctx->render('login-form');
} else {
    http_response_code(HTTP_METHOD_NOT_ALLOWED);
}
