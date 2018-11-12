<?php
http_response_code(404);
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
