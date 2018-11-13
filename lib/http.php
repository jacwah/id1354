<?php
const HTTP_SEE_OTHER = 303;
const HTTP_FORBIDDEN = 403;
const HTTP_NOT_FOUND = 404;
const HTTP_METHOD_NOT_ALLOWED = 405;
const HTTP_UNPROCESSABLE = 422;
const HTTP_INTERNAL_ERROR = 500;

function http_redirect($target, $status=HTTP_SEE_OTHER) {
    header("Location: $target", true, $status);
    die();
}

function http_render_404() {
    if (headers_sent($filename)) {
        trigger_error("Mixing 404 page with $filename", E_USER_WARNING);
    }
    http_response_code(HTTP_NOT_FOUND);
    require '404.php';
    die();
}
