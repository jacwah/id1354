<?php
namespace TastyRecipes\Controller;

use \TastyRecipes\Model\Password;
use \TastyRecipes\Integration\Datastore;

class LoginController {
    private $user;

    public function __construct(string $username, string $plaintext_password) {
        $store = Datastore::getInstance();
        $stored_password = $store->getUserPasswordByName($username);
        if ($stored_password->matchesPlaintext($plaintext_password))
            $this->user = $store->getUserByName($username);
        else
            throw new UserNotFoundException();
    }

    public function saveSession(string $session_id) {
        $store = Datastore::getInstance();
        $store->saveSession($this->user, $session_id);
    }
}
