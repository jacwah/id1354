<?php
namespace TastyRecipes\Controller;

use \TastyRecipes\Integration\Datastore;
use \TastyRecipes\Integration\NameTakenException;

class RegistrationController {
    public function register(string $username, string $password) {
        $store = Datastore::getInstance();
        $store->createUser($username, $password);
    }
}
