<?php
namespace TastyRecipes\Util;

class Http {
    public const SEE_OTHER = 303;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const UNPROCESSABLE = 422;
    public const INTERNAL_ERROR = 500;

    public static function redirect($target) {
        header("Location: $target", true, static::SEE_OTHER);
        die();
    }
}
