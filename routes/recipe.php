<?php
use \TastyRecipes\Model\Comment;
use \TastyRecipes\Model\ValidationException;
use \TastyRecipes\Controller\RecipeController;
use \TastyRecipes\Controller\CommentController;
use \TastyRecipes\View\Http;
use \TastyRecipes\View\StatusMessage;

try {
    $recipe_cntr = new RecipeController($_SERVER['DOCUMENT_ROOT']);
    $recipe_name = $_REQUEST['name'];
    $recipe = $recipe_cntr->findRecipeByName($recipe_name);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = $_POST['content'];

        if (!isset($user_cntr)) {
            http_response_code(Http::FORBIDDEN);
        } else {
            $comment_cntr = new CommentController($user_cntr->getUser());
            try {
                $new_comment = $comment_cntr->post($recipe_name, $content);
                Http::redirect('/recipe?name=' . $recipe_name . '#comment-' . $new_comment->getId());
            } catch (ValidationException $e) {
                $error = StatusMessage::commentValidation($e);
            } catch (DatastoreException $e) {
                $error = StatusMessage::DATABASE_ERROR;
            }
        }
    }

    $comments = $recipe_cntr->getComments($recipe);
    require 'views/recipe.php';
} catch (RecipeNotFoundException $e) {
    http_response_code(Http::NOT_FOUND);
    require 'views/404.php';
}

