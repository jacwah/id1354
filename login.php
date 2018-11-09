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
                $error = "please try again";
            }
        } else if ($db->succeeded) {
            $error = "wrong username or password";
        } else {
            $error = "please try again";
        }
    } else {
        $error = "please try again";
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
            <p>
                <?php
                if ($_GET['from'] === 'login')
                    echo 'Login successful.';
                else if ($_GET['from'] === 'logout')
                    echo 'Logout successful.';
                else if ($_GET['from'] === 'register')
                    echo 'Registration successful.';
                ?>
            </p>
            <?php endif ?>
            <?php if ($current_user): ?>
            <p>You are logged in as <b><?php echo $current_user['name'] ?></b>.</p>
            <?php else: ?>
            <?php if ($error): ?>
            <div class="form-error">
                <p>Error: <?php echo $error ?>.</p>
            </div>
            <?php else: ?>
            <div class="cookie-notice">
                <p>Note: this site uses cookies to authenticate logged in users.</p>
            </div>
            <?php endif ?>
            <form action="/login.php" method="post">
                <div class="inputgroup">
                    <label for="username">Username</label>
                    <input type="text" name="username" required/>
                </div>
                <div class="inputgroup">
                    <label for="password">Password</label>
                    <input type="password" name="password" required/>
                </div>
                <input type="submit" value="Login"/>
            </form>
            <p><a href="/register.php">Register</a></p>
            <?php endif ?>
        </main>
    </body>
</html>
