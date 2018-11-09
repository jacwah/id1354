<?php
/* Known security issues:
   - Cookies not httponly and secure
   - No csrf protection
 */
require_once 'db.php';
user_setup_session($_COOKIE['session_id']);

function user_setup_session($session_id) {
    if ($session_id) {
        $conn = db_connect();
        if ($conn) {
            $session = db_get_session($conn, $session_id);
            if ($session) {
                user_set_current($session);
            }
        }
    }
}

function user_create_session(int $user_id) {
    $conn = db_connect();
    if ($conn) {
        $session = db_create_session($conn, $user_id);
        if ($session) {
            setcookie('session_id', $session['id']);
            user_set_current($session);
        } else {
            error_log("Failed to create session for user with id $user_id");
        }
    }
    return $session;
}

function user_destroy_session() {
    global $current_user;
    unset($current_user);
    $session_id = $_COOKIE['session_id'];
    unset($_COOKIE['session_id']);
    setcookie('session_id', '');
    $conn = db_connect();
    if ($conn && $session_id)
        db_delete_session($conn, $session_id);
}

function user_set_current(array $session) {
    global $current_user;
    $current_user = ['name' => $session['username'], 'id' => $session['user_id']];
}
?>
