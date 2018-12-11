<?php
use \TastyRecipes\Model\Comment;
use \TastyRecipes\Model\ValidationException;
use \TastyRecipes\Controller\RecipeController;
use \TastyRecipes\Controller\CommentController;
use \TastyRecipes\Integration\RecipeNotFoundException;
use \TastyRecipes\View\StatusMessage;
use \TastyRecipes\View\Http;
use \TastyRecipes\View\Json;
use \TastyRecipes\View\Params;
use \TastyRecipes\Integration\NoResultException;

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
            Json::write(array_map(function(Comment $comment) {
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
        $params = new Params();
        $recipe_name = $params->getString('recipe-name');
        $recipe_cntr = new RecipeController($_SERVER['DOCUMENT_ROOT']);
        $recipe = $recipe_cntr->findRecipeByName($recipe_name);
        $comment_cntr = new CommentController($user_cntr->getUser());
        $comment = $comment_cntr->post($recipe, $params->getString('content'));
        header("Content-Location: /api/comments?recipe-name=$recipe_name");
        Json::write(['id' => $comment->getId()]);
    } catch (RecipeNotFoundException $e) {
        http_response_code(Http::NOT_FOUND);
    } catch (ValidationException $e) {
        Json::write(['error' => StatusMessage::commentValidation($e)]);
        http_response_code(Http::UNPROCESSABLE);
    }
    break;
case 'DELETE':
    try {
        $params = new Params();
        $comment_id = $params->getInt('id');
        $comment_cntr = new CommentController($user_cntr->getUser());
        $comment = $comment_cntr->findComment($comment_id);
        $recipe_name = $comment->getRecipename();
        $comment_cntr->delete($comment);
        header("Content-Location: /api/comments?recipe-name=$recipe_name");
    } catch (NoResultException $e) {
        http_response_code(Http::NOT_FOUND);
    }
    break;
default:
    http_response_code(Http::METHOD_NOT_ALLOWED);
}
