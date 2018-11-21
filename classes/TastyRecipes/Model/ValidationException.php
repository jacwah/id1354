<?php
namespace TastyRecipes\Model;

class ValidationException extends \Exception {
    private $type;

    public function __construct(int $type) {
        $this->type = $type;
    }

    public function getType() {
        return $this->type;
    }
}
