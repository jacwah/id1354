<?php
namespace TastyRecipes\Controller;

use \TastyRecipes\Integration\Datastore;

class UserController {
    private $user;
    private $session_id;

    public function __construct(string $session_id) {
        $store = Datastore::getInstance();
        $this->user = $store->getUserBySessionId($session_id);
        $this->session_id = $session_id;
    }

    public function getUser() {
        return $this->user;
    }

    public function logout() {
        $store = Datastore::getInstance();
        $store->deleteSession($this->session_id);
    }
}
