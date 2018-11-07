<?php session_start() ?>
<?php
require_once 'db.php';
if ($_POST['username'] && $_POST['password']) {
    $conn = db_connect();
    if ($conn) {
        $query = 'SELECT password = "' . mysqli_real_escape_string($conn, $_POST['password']) . '" FROM SiteUser WHERE name = "' . mysqli_real_escape_string($conn, $_POST['username']) . '";';
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = $result->fetch_row();
            if ($row) {
                if ($row[0]) {
                    $_SESSION['username'] = $_POST['username'];
                } else {
                    $error = "wrong password";
                }
            } else {
                $error = "unregistered username";
            }
        } else {
            error_log(mysqli_error($conn));
        }
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
            <?php if ($_SESSION['username']): ?>
                <p>You are logged in as <b><?php echo $_SESSION['username']?></b>.</p>
            <?php else: ?>
            <?php if ($error): ?>
            <div class="form-error">
                <p>Login error: <?php echo $error ?>.</p>
            </div>
            <?php endif ?>
            <form action="/login.php" method="post">
                <input type="text" name="username" required/>
                <input type="password" name="password" required/>
                <input type="submit" value="Login"/>
            </form>
            <p><a href="/register.php">Register</a></p>
            <?php endif ?>
        </main>
    </body>
</html>
