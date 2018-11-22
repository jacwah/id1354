<?php
use \TastyRecipes\Controller\RegistrationController;
use \TastyRecipes\Integration\NameTakenException;
use \TastyRecipes\Model\ValidationException;
use \TastyRecipes\View\Http;

if (isset($user_cntr)) {
    Http::redirect('/login');
}

if ($_POST['username'] && $_POST['password']) {
    $reg_cntr = new RegistrationController();
    try {
        $reg_cntr->register($_POST['username'], $_POST['password']);
        Http::redirect('/login?registred');
    } catch (NameTakenException $e) {
        $error = 'That name is already taken';
    } catch (ValidationException $e) {
        $error = 'Username can only contain alphanumerical characters';
    }
}

require 'views/register-form.php';
