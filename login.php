<?php
require_once 'user.php';
require_once 'db.php';
require_once 'redirect.php';
if ($_POST['username'] && $_POST['password']) {
    if ($db->connected()) {
        $user_id = $db->userIdIfPasswordOk($_POST['username'], $_POST['password']);
        if (isset($user_id)) {
            $session = user_create_session($db, $user_id);
            if ($session) {
                redirect('/login.php?from=login');
            } else {
                $error = "Please try again";
            }
        } else if ($db->succeeded()) {
            $error = "Wrong username or password";
        } else {
            $error = "Please try again";
        }
    } else {
        $error = "Please try again";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'fragments/common-head.html'?>
        <title>Tasty Recipes login</title>
    </head>
    <body>
        <?php include 'fragments/navbar.php'?>
        <main>
            <h1>Login</h1>
            <?php if ($_GET['from']): ?>
            <p class="status-success">
                <?php
                if ($_GET['from'] === 'login')
                    echo 'Logged in.';
                else if ($_GET['from'] === 'logout')
                    echo 'Logged out.';
                else if ($_GET['from'] === 'register')
                    echo 'User registered.';
                ?>
            </p>
            <?php endif ?>
            <?php if ($current_user): ?>
            <p class="note">You are logged in as <span class="username"><?php echo $current_user['name'] ?></span>.</p>
            <?php else: ?>
            <?php if ($error): ?>
            <p class="status-error"><?= $error ?>.</p>
            <?php else: ?>
            <div class="note">
                <p>Note: this site uses cookies to authenticate logged in users.</p>
            </div>
            <?php endif ?>
            <form action="/login.php" method="post" class="user-password">
                <?php require 'fragments/user_password_form.php' ?>
            </form>
            <p>Not a member yet? <a href="/register.php">Register</a> today!</p>
            <?php endif ?>
        </main>
    </body>
</html>
