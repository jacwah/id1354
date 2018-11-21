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
            <p class="note">You are logged in as <span class="username"><?= $user_cntr->getUser()->getName() ?></span>.</p>
        </main>
    </body>
</html>
