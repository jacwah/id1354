<?php
namespace TastyRecipes\Controller;

use \TastyRecipes\Model\Password;
use \TastyRecipes\Model\ValidationException;
use \TastyRecipes\Integration\Datastore;
use \TastyRecipes\Integration\NameTakenException;

class RegistrationController {
    public function register(string $username, string $plaintext_password) {
        if (strlen($username) < 1 || !ctype_alnum($username))
            throw new ValidationException();
        $store = Datastore::getInstance();
        $password = Password::fromPlaintext($plaintext_password);
        $store->createUser($username, $password);
    }
}
