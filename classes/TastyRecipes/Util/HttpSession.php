<?php
namespace TastyRecipes\Util;

class HttpSession {
    private const COOKIE_NAME = 'session_id';
    private const NUM_ID_BYTES = 16;

    private static function generateId() {
        return bin2hex(random_bytes(static::NUM_ID_BYTES));
    }

    public static function getId() {
        return $_COOKIE[static::COOKIE_NAME];
    }

    public static function start() {
        $id = self::generateId();
        $_COOKIE[static::COOKIE_NAME] = $id;
        setcookie(static::COOKIE_NAME, $id);
        return $id;
    }

    public static function kill() {
        unset($_COOKIE[static::COOKIE_NAME]);
        setcookie(static::COOKIE_NAME, '');
    }
}
