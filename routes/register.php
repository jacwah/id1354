<?php
use \TastyRecipes\Controller\RegistrationController;
use \TastyRecipes\Integration\NameTakenException;
use \TastyRecipes\Model\ValidationException;
use \TastyRecipes\View\Http;

if ($user_cntr->loggedIn()) {
    Http::redirect('/login');
} else if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $reg_cntr = new RegistrationController();
    try {
        $reg_cntr->register($_POST['username'], $_POST['password']);
        Http::redirect('/login?registred');
    } catch (NameTakenException $e) {
        $ctx->set('error', 'That name is already taken');
    } catch (ValidationException $e) {
        $ctx->set('error', 'Username can only contain alphanumerical characters');
    }
}

$ctx->render('register-form');
