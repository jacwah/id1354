<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'fragments/common-head.html'?>
        <title>Tasty Recipes login</title>
    </head>
    <body>
        <?php require 'fragments/navbar.php'?>
        <main>
            <h1>Login</h1>
            <?php if (isset($_GET['registered'])): ?>
            <p class="status-success">
                User registered.
            </p>
            <?php endif ?>
            <?php if (isset($_GET['logged-out'])): ?>
            <p class="status-success">
                Logged out.
            </p>
            <?php endif ?>
            <?php if ($error): ?>
            <p class="status-error"><?= $error ?>.</p>
            <?php endif ?>
            <div class="note">
                <p>Note: this site uses cookies to authenticate logged in users.</p>
            </div>
            <form action="/login.php" method="post" class="user-password">
                <?php require 'fragments/user-password-fields.html' ?>
                <div class="inputgroup">
                    <input type="submit" value="Login"/>
                </div>
            </form>
            <p>Not a member yet? <a href="/register.php">Register</a> today!</p>
        </main>
    </body>
</html>