<?php
require_once 'db.php';
require_once 'redirect.php';
if ($_POST['username'] && $_POST['password']) {
    $conn = db_connect();
    if ($conn) {
        $query = 'INSERT INTO SiteUser (username, password) VALUES ("' .
            mysqli_real_escape_string($conn, $_POST['username']) .
            '", "' .
            mysqli_real_escape_string($conn, $_POST['password']) .
            '");';
        error_log($query);
        if (mysqli_query($conn, $query)) {
            redirect('/login.php?from=register');
        } else {
            error_log(mysqli_error($conn));
            if (mysqli_errno($conn) == 1062) {
                $error = "that name is already taken";
            } else {
                $error = "unexpected error";
            }
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
            <?php if ($error): ?>
            <div class="form-error">
                <p>Error: <?php echo $error ?>.</p>
            </div>
            <?php endif ?>
            <form action="/register.php" method="post">
                <input type="text" name="username" required/>
                <input type="password" name="password" required/>
                <input type="submit" value="Register"/>
            </form>
        </main>
    </body>
</html>
