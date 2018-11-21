<?php
use \TastyRecipes\Controller\RecipeController;
use \TastyRecipes\Util\Http;

try {
    $recipe_cntr = new RecipeController();
    $recipe_name = $_GET['name'];
    $recipe = $recipe_cntr->findRecipeByName($recipe_name);
    $comments = $recipe_cntr->getComments($recipe);
    switch ($_GET['comment']) {
    case 'delete_failed':
        $status = 'Failed to delete comment. Please try again later!';
        break;
    case 'create_failed':
        $status = 'Failed to add comment. Please try again later!';
        break;
    case 'deleted':
        $status = 'Comment successfully deleted.';
    }
    require 'views/recipe.php';
} catch (RecipeNotFoundException $e) {
    http_response_code(Http::NOT_FOUND);
    require 'views/404.php';
}

