<?php
use \TastyRecipes\Controller\CommentController;
use \TastyRecipes\Util\Http;

$recipe_name = $_POST['recipe_name'];
$content = $_POST['content'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    http_response_code(Http::METHOD_NOT_ALLOWED);
else if (!$recipe_name || !$content)
    http_response_code(Http::UNPROCESSABLE);
else if (!$user_cntr)
    http_response_code(Http::FORBIDDEN);
else {
    $comment_cntr = new CommentController($user_cntr->getUser());
    $path = "/recipe.php?name=$recipe_name";
    try {
        $comment = $comment_cntr->post($recipe_name, $content);
        Http::redirect($path . '#comment-' . $comment->getId());
    } catch (DatastoreException $e) {
        Http::redirect($path . "&comment=create_failed#comments");
    }
}
