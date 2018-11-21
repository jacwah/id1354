<?php
use \TastyRecipes\Util\Http;
use \TastyRecipes\Util\HttpSession;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user_cntr)
        $user_cntr->logout();
    HttpSession::kill();
    Http::redirect('/login.php?logged-out');
} else {
    http_response_code(HTTP_METHOD_NOT_ALLOWED);
}
