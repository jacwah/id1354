<?php
use \TastyRecipes\Model\Comment;
use \TastyRecipes\Model\ValidationException;
use \TastyRecipes\Controller\RecipeController;
use \TastyRecipes\Controller\CommentController;
use \TastyRecipes\Integration\RecipeNotFoundException;
use \TastyRecipes\View\Http;
use \TastyRecipes\View\StatusMessage;

try {
    $recipe_cntr = new RecipeController($_SERVER['DOCUMENT_ROOT']);
    $recipe_name = $_REQUEST['name'];
    $recipe = $recipe_cntr->findRecipeByName($recipe_name);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = $_POST['content'];

        if (!$user_cntr->loggedIn()) {
            http_response_code(Http::FORBIDDEN);
        } else {
            $comment_cntr = new CommentController($user_cntr->getUser());
            try {
                $new_comment = $comment_cntr->post($recipe, $content);
                Http::redirect('/recipe?name=' . $recipe_name . '#comment-' . $new_comment->getId());
            } catch (ValidationException $e) {
                $ctx->set('error', StatusMessage::commentValidation($e));
            } catch (DatastoreException $e) {
                $ctx->set('error', StatusMessage::DATABASE_ERROR);
            }
        }
    }

    $ctx->set('page_name', $recipe->getTitle());
    $ctx->add('page_style', '/style/recipe.css');
    $ctx->add('page_script', '/scripts/comments.js');
    $ctx->assoc('page_data', 'recipe-name', $recipe_name);
    $ctx->set('recipe', $recipe);
    $ctx->set('recipe_name', $recipe_name);
    $ctx->render('recipe');
} catch (RecipeNotFoundException $e) {
    http_response_code(Http::NOT_FOUND);
    $ctx->set('page_name', 'Recipe not found');
    $ctx->render('404');
}

