<?php session_start() ?>
<?php
unset($_SESSION['username']);
header('Location: /login.php', true, 303);
?>
