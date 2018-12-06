<?php
namespace TastyRecipes\Model;

class User {
    private $id;
    private $name;

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function equals($other) {
        return $other instanceof User && $this->getId() === $other->getId();
    }
}
