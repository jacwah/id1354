<?php
namespace TastyRecipes\View;

class HttpCache {
    public static function setHeaders(bool $logged_in) {
        header('Vary: Cookie');
        if ($logged_in)
            header('Cache-Control: private');
    }
}
