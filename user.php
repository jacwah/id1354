<?php
$current_user = $_COOKIE['username'];

function set_current_user($name) {
    global $current_user;
    $current_user = $name;
    setcookie('username', $name, 0);
}

function unset_current_user() {
    global $current_user;
    unset($GLOBALS['current_user']);
    setcookie('username', '');
}
?>
