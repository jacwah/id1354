<?php
use \TastyRecipes\View\Http;
use \TastyRecipes\View\HttpSession;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user_cntr->loggedIn())
        $user_cntr->logout();
    if (isset($http_session))
        $http_session->kill();
} else {
    http_response_code(Http::METHOD_NOT_ALLOWED);
}
