<?php
use \TastyRecipes\Model\Comment;
use \TastyRecipes\Controller\RecipeController;
use \TastyRecipes\Controller\CommentController;
use \TastyRecipes\Integration\RecipeNotFoundException;
use \TastyRecipes\View\Http;
use \TastyRecipes\Integration\NoResultException;

$input = file_get_contents('php://input');
$request = json_decode($input);

switch ($_SERVER['REQUEST_METHOD']) {
case 'GET':
    try {
        $recipe_name = $_GET['recipe-name'];
        if (empty($recipe_name)) {
            throw new RecipeNotFoundException();
        } else {
            $recipe_cntr = new RecipeController($_SERVER['DOCUMENT_ROOT']);
            $recipe = $recipe_cntr->findRecipeByName($recipe_name);
            $comments = $recipe_cntr->getComments($recipe);
            echo json_encode(array_map(function(Comment $comment) {
                global $user_cntr;
                return [
                    'id' => $comment->getId(),
                    'username' => $comment->getPoster()->getName(),
                    'content' => $comment->getContent(),
                    'deletable' => $comment->getPoster()->equals($user_cntr->getUser())
                ];
            }, $comments));
        }
    } catch (RecipeNotFoundException $e) {
        http_response_code(Http::NOT_FOUND);
    }
    break;
case 'POST':
    try {
        if (empty($recipe_name)) {
            throw new RecipeNotFoundException();
        } else {
            $recipe_cntr = new RecipeController($_SERVER['DOCUMENT_ROOT']);
            $recipe = $recipe_cntr->findRecipeByName($recipe_name);
            $comment_cntr = new CommentController($user_cntr->getUser());
            // validation
            $comment = $comment_cntr->post($recipe, $request->content);
        }
    } catch (RecipeNotFoundException $e) {
        http_response_code(Http::NOT_FOUND);
    }
    break;
case 'DELETE':
    try {
        $comment_id = $request->id;
        $comment_cntr = new CommentController($user_cntr->getUser());
        $comment = $comment_cntr->findComment($comment_id);
        $comment_cntr->delete($comment);
    } catch (NoResultException $e) {
        http_response_code(Http::NOT_FOUND);
    }
    break;
default:
    http_response_code(Http::METHOD_NOT_ALLOWED);
}
