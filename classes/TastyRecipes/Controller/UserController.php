<?php
namespace TastyRecipes\Controller;

use \TastyRecipes\Integration\Datastore;

class UserController {
    private $user;
    private $session_id;

    public function authenticate(string $session_id) {
        $store = Datastore::getInstance();
        $this->user = $store->findUserBySessionId($session_id);
        $this->session_id = $session_id;
    }

    public function loggedIn() {
        return isset($this->user);
    }

    public function getUser() {
        return $this->user;
    }

    public function logout() {
        $store = Datastore::getInstance();
        $store->deleteSession($this->session_id);
    }
}
