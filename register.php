<?php
use \TastyRecipes\Controller\RegistrationController;
use \TastyRecipes\Integration\NameTakenException;
use \TastyRecipes\Util\Http;

if (isset($user_cntr)) {
    Http::redirect('/login.php');
}

if ($_POST['username'] && $_POST['password']) {
    $reg_cntr = new RegistrationController();
    try {
        $reg_cntr->register($_POST['username'], $_POST['password']);
        Http::redirect('/login.php?registred');
    } catch (NameTakenException $e) {
        $error = 'That name is already taken';
    }
}

require 'views/register-form.php';
