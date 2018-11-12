<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'lib/user.php';
    require_once 'lib/redirect.php';
    user_destroy_session($db);
    redirect('/login.php?from=logout');
}
