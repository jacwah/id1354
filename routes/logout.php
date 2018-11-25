<?php
use \TastyRecipes\View\Http;
use \TastyRecipes\View\HttpSession;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($user_cntr))
        $user_cntr->logout();
    if (isset($http_session))
        $http_session->kill();
    $logged_out = TRUE;
    require 'views/login-form.php';
} else {
    http_response_code(HTTP_METHOD_NOT_ALLOWED);
}
