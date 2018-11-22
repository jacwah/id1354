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
            <form action="/register" method="post" class="user-password">
                <?php require 'fragments/user-password-fields.html' ?>
                <div class="inputgroup">
                    <input type="submit" value="Register"/>
                </div>
            </form>
            <p>Already a member? <a href="/login">Log in</a> instead.</p>
        </main>
    </body>
</html>
