<?php
require_once 'db.php';
require_once 'user.php';
require_once 'redirect.php';

if (isset($current_user)) {
    redirect('/login.php');
}

if ($_POST['username'] && $_POST['password']) {
    if ($db->connected()) {
        $error = $db->registerUser($_POST['username'], $_POST['password']);
        if (!isset($error)) {
            redirect('/login.php?from=register');
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
                <?php require 'fragments/user_password_form.php' ?>
            </form>
            <p>Already a member? <a href="/login.php">Log in</a> instead.</p>
        </main>
    </body>
</html>
