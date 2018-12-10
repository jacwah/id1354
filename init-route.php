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
$ctx->set('current_user', $user_cntr->getUser());
$ctx->set('site_name', 'Tasty Recipes');
$ctx->set('page_style', ['/style/reset.css', '/style/main.css']);
$ctx->set('page_script', ['/scripts/jquery.js', '/scripts/pagedata.js', '/scripts/user.js']);
$ctx->set('page_data', []);
if ($user_cntr->loggedIn())
    $ctx->assoc('page_data', 'username', $user_cntr->getUser()->getName());
