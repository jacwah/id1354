<?php
namespace TastyRecipes\Controller;

use \TastyRecipes\Integration\Datastore;

class LoginController {
    private $user;

    public function __construct(string $username, string $password) {
        $store = Datastore::getInstance();
        $this->user = $store->getUserWithPassword($username, $password);
    }

    public function saveSession(string $session_id) {
        $store = Datastore::getInstance();
        $store->saveSession($this->user, $session_id);
    }
}
