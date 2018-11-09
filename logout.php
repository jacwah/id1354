<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'user.php';
    require_once 'redirect.php';
    unset_current_user();
    redirect('/login.php?from=logout');
}
?>
