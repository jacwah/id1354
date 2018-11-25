<?php
use \TastyRecipes\Controller\CommentController;
use \TastyRecipes\View\Http;

$comment_id = (int)$_POST['id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    http_response_code(Http::METHOD_NOT_ALLOWED);
else if (empty($comment_id))
    http_response_code(Http::UNPROCESSABLE);
else if (!isset($user_cntr))
    http_response_code(Http::FORBIDDEN);
else {
    $comment_cntr = new CommentController($user_cntr->getUser());
    $comment = $comment_cntr->findComment($comment_id);
    $recipe_name = $comment->getRecipeName();
    $path = "/recipe?name=$recipe_name";
    $comment_cntr->delete($comment);
    Http::redirect($path . "#comments");
}
