<?php
require_once 'lib/db.php';
require_once 'lib/user.php';
require_once 'lib/http.php';

if (isset($current_user)) {
    http_redirect('/login.php');
}

if ($_POST['username'] && $_POST['password']) {
    if ($db->connected()) {
        $error = $db->registerUser($_POST['username'], $_POST['password']);
        if (!isset($error)) {
            http_redirect('/login.php?from=register');
        }
    } else {
        $error = "Unexpected error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'fragments/common-head.html'?>
        <title>Tasty Recipes registration</title>
    </head>
    <body>
        <?php require 'fragments/navbar.php'?>
        <main>
            <h1>Register</h1>
            <?php if ($error): ?>
            <p class="status-error"><?= $error ?>.</p>
            <?php endif ?>
            <form action="/register.php" method="post" class="user-password">
                <?php require 'fragments/user-password-fields.html' ?>
                <div class="inputgroup">
                    <input type="submit" value="Register"/>
                </div>
            </form>
            <p>Already a member? <a href="/login.php">Log in</a> instead.</p>
        </main>
    </body>
</html>
