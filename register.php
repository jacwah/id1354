<?php
require_once 'db.php';
if ($_POST['username'] && $_POST['password']) {
    $conn = db_connect();
    if ($conn) {
        $query = 'INSERT INTO SiteUser (name, password) VALUES ("' . mysqli_real_escape_string($conn, $_POST['username']) . '", "' . mysqli_real_escape_string($conn, $_POST['password']) . '");';
        error_log($query);
        if (mysqli_query($conn, $query)) {
            header('Location: /login.php?register=success', true, 303);
            die();
        } else {
            // make nice errors for uniqueness violation
            error_log(mysqli_error($conn));
            die('failed to insert row');
        }
    } else {
        // 500 page?
        die('failed to connect to database');
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
            <form action="/register.php" method="post">
                <input type="text" name="username" required/>
                <input type="password" name="password" required/>
                <input type="submit" value="Register"/>
            </form>
        </main>
    </body>
</html>
