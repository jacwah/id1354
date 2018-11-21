<?php
use \TastyRecipes\Controller\LoginController;
use \TastyRecipes\Controller\UserController;
use \TastyRecipes\Util\HttpSession;
use \TastyRecipes\Integration\UserNotFoundException;

if ($user_cntr) {
    require 'views/logged-in.php';
    die();
} else if ($_POST['username'] && $_POST['password']) {
    try {
        $login_cntr = new LoginController($_POST['username'], $_POST['password']);
        $session_id = HttpSession::start();
        $login_cntr->saveSession($session_id);
        $user_cntr = new UserController($session_id);

        require 'views/logged-in.php';
        die();
    } catch (UserNotFoundException $e) {
        $error = 'Wrong username or password';
    } /*catch (DatastoreExcpetion $e) {
        $error = 'Please try again.';
    }*/
}

require 'views/login-form.php';
