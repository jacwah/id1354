<?php
use \TastyRecipes\Controller\RegistrationController;
use \TastyRecipes\Integration\NameTakenException;
use \TastyRecipes\Model\ValidationException;
use \TastyRecipes\View\Http;

if ($user_cntr->loggedIn()) {
    $ctx->set('page_name', 'Login');
    $ctx->render('logged-in');
    die();
} else if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $reg_cntr = new RegistrationController();
    try {
        $reg_cntr->register($_POST['username'], $_POST['password']);
        $ctx->set('page_name', 'Login');
        $ctx->set('success', 'Registered');
        $ctx->render('login-form');
        die();
    } catch (NameTakenException $e) {
        $ctx->set('error', 'That name is already taken');
    } catch (ValidationException $e) {
        $ctx->set('error', 'Username can only contain alphanumerical characters');
    }
}

$ctx->set('page_name', 'Register');
$ctx->render('register-form');
