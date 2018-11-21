<?php
namespace TastyRecipes\Model;

class ValidationException extends \Exception {
    private $type;

    public function __construct(int $type = 0) {
        $this->type = $type;
    }

    public function getType() {
        return $this->type;
    }
}
