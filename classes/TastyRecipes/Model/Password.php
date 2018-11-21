<?php
namespace TastyRecipes\Model;

class Password {
    private $hash;

    private function __construct(string $hash) {
        $this->hash = $hash;
    }

    public static function fromPlaintext(string $plaintext) {
        // Could do validation here
        return new static(password_hash($plaintext, PASSWORD_DEFAULT));
    }

    public static function fromHash(string $hash) {
        // Validate with password_info
        return new static($hash);
    }

    public function matchesPlaintext(string $plaintext) {
        return password_verify($plaintext, $this->hash);
    }

    public function getHash() {
        return $this->hash;
    }
}
