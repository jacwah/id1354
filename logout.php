<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'user.php';
    require_once 'redirect.php';
    user_destroy_session();
    redirect('/login.php?from=logout');
}
?>
