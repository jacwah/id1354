<?php
namespace TastyRecipes\Controller;

use \TastyRecipes\Model\Recipe;
use \TastyRecipes\Integration\Cookbook;
use \TastyRecipes\Integration\Datastore;

class RecipeController {
    private $cookbook;

    public function __construct() {
        $this->cookbook = new Cookbook();
    }

    public function findRecipeByName(string $name) {
        return $this->cookbook->findRecipeByName($name);
    }

    public function getComments(Recipe $recipe) {
        $datastore = Datastore::getInstance();
        $comments = $datastore->loadComments($recipe->getName());
        return $comments;
    }
}
