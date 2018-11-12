<?php
/* Known security issues:
   - Cookies not httponly and secure
   - No csrf protection
   - User data is not HTML escaped (XSS)
 */
require_once 'lib/db.php';
user_setup_session($db, $_COOKIE['session_id']);

function user_setup_session(Database $db, $session_id) {
    if ($session_id) {
        if ($db->connected()) {
            $session = $db->getSession($session_id);
            if ($session) {
                user_set_current($db, $session);
            }
        }
    }
}

function user_create_session(Database $db, int $user_id) {
    if ($db->connected()) {
        $session = $db->createSession($user_id);
        if ($session) {
            setcookie('session_id', $session['id']);
            user_set_current($db, $session);
        } else {
            error_log("Failed to create session for user with id $user_id");
        }
    }
    return $session;
}

function user_destroy_session(Database $db) {
    global $current_user;
    unset($current_user);
    $session_id = $_COOKIE['session_id'];
    unset($_COOKIE['session_id']);
    setcookie('session_id', '');
    if ($db->connected() && $session_id)
        $db->deleteSession($session_id);
}

function user_set_current(Database $db, array $session) {
    global $current_user;
    $current_user = ['name' => $session['username'], 'id' => $session['user_id']];
}
