<?php
use \TastyRecipes\Controller\UserController;
use \TastyRecipes\Integration\UserNotFoundException;
use \TastyRecipes\View\HttpSession;
use \TastyRecipes\View\HttpCache;
use \TastyRecipes\View\RenderContext;
use \TastyRecipes\View\NoSessionException;

spl_autoload_register(function(string $class) {
    $path = 'classes/' . str_replace('\\', '/', $class) . '.php';
    require_once $path;
});

$user_cntr = new UserController();
try {
    $http_session = HttpSession::resume();
    $user_cntr->authenticate($http_session->getId());
} catch (UserNotFoundException $e) {
    // Don't leave invalid session cookie lying around
    $http_session->kill();
} catch (NoSessionException $e) {
}

HttpCache::setHeaders($user_cntr->loggedIn());
$ctx = new RenderContext('main');
$ctx->set('user_cntr', $user_cntr);
$ctx->set('site_name', 'Tasty Recipes');
