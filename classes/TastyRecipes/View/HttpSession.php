<?php
namespace TastyRecipes\View;

class HttpSession {
    private const COOKIE_NAME = 'session_id';
    private const NUM_ID_BYTES = 16;

    private $id;

    private function __construct(string $id) {
        $this->id = $id;
    }

    public static function resume() {
        if (empty($_COOKIE[static::COOKIE_NAME]))
            throw new NoSessionException();
        $id = $_COOKIE[static::COOKIE_NAME];
        if (!static::isValidId($id))
            throw new NoSessionException();
        else
            return new static($id);
    }

    public static function create() {
        $id = self::generateId();
        $_COOKIE[static::COOKIE_NAME] = $id;
        setcookie(static::COOKIE_NAME, $id, 0, '/');
        return new static($id);
    }

    private static function generateId() {
        return bin2hex(random_bytes(static::NUM_ID_BYTES));
    }

    private static function isValidId(string $id) {
        return strlen($id) === 2*static::NUM_ID_BYTES && ctype_xdigit($id);
    }

    public function getId() {
        return $this->id;
    }

    public function kill() {
        unset($_COOKIE[static::COOKIE_NAME]);
        setcookie(static::COOKIE_NAME, '', time() - 3600, '/');
    }
}
