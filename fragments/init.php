<?php
use \TastyRecipes\Controller\UserController;
use \TastyRecipes\Integration\UserNotFoundException;
use \TastyRecipes\Util\Http;
use \TastyRecipes\Util\HttpSession;

spl_autoload_register(function(string $class) {
    $path = 'classes/' . str_replace('\\', '/', $class) . '.php';
    error_log('Loading file ' . $path);
    require_once $path;
});

try {
    if (HttpSession::getId())
        $user_cntr = new UserController(HttpSession::getId());
} catch (UserNotFoundException $e) {}
