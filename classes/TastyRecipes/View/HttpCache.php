<?php
namespace TastyRecipes\View;

class HttpCache {
    private const MAX_AGE = 60*60;

    public static function setHeaders(bool $logged_in) {
        header('Vary: Cookie');
        if ($logged_in)
            header('Cache-Control: private');
    }
}
