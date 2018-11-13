<?php
require_once 'lib/http.php';

if (headers_sent($filename))
    trigger_error("Mixing 404 page with $filename", E_USER_WARNING);
http_response_code(HTTP_NOT_FOUND);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'fragments/common-head.html'?>
        <title>Not found</title>
    </head>
    <body>
        <?php require 'fragments/navbar.php'?>
        <main>
            <h1>Not found</h1>
            <p>Sorry about that.</p>
            <p>Go to the <a href="/">home page</a> instead.</p>
        </main>
    </body>
</html>
