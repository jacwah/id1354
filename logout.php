<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'lib/user.php';
    require_once 'lib/http.php';
    user_destroy_session($db);
    http_redirect('/login.php?from=logout');
} else {
    http_response_code(HTTP_METHOD_NOT_ALLOWED);
}
