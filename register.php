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
        $error = "unexpected error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'fragments/common-head.html'?>
        <title>Tasty Recipes registration</title>
    </head>
    <body>
        <?php include 'fragments/navbar.php'?>
        <main>
            <h1>Register</h1>
            <?php if ($error): ?>
            <div class="form-error">
                <p>Error: <?php echo $error ?>.</p>
            </div>
            <?php endif ?>
            <form action="/register.php" method="post">
                <div class="inputgroup">
                    <label for="username">Username</label>
                    <input type="text" name="username" required/>
                </div>
                <div class="inputgroup">
                    <label for="password">Password</label>
                    <input type="password" name="password" required/>
                </div>
                <input type="submit" value="Register"/>
            </form>
            <p>Already a member? <a href="/login.php">Log in</a> instead.</p>
        </main>
    </body>
</html>
