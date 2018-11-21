<?php
use \TastyRecipes\View\Http;
use \TastyRecipes\View\HttpSession;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user_cntr)
        $user_cntr->logout();
    if ($http_session)
        $http_session->kill();
    Http::redirect('/login.php?logged-out');
} else {
    http_response_code(HTTP_METHOD_NOT_ALLOWED);
}
