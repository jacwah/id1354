<?php
use \TastyRecipes\Controller\UserController;
use \TastyRecipes\Integration\UserNotFoundException;
use \TastyRecipes\View\HttpSession;
use \TastyRecipes\View\HttpCache;
use \TastyRecipes\View\NoSessionException;

spl_autoload_register(function(string $class) {
    $path = 'classes/' . str_replace('\\', '/', $class) . '.php';
    require_once $path;
});

try {
    $http_session = HttpSession::resume();
    $user_cntr = new UserController($http_session->getId());
} catch (UserNotFoundException $e) {
    // Don't leave invalid session cookie lying around
    $http_session->kill();
} catch (NoSessionException $e) {
}

HttpCache::setHeaders(isset($user_cntr));
