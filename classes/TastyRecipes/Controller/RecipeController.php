<?php
namespace TastyRecipes\Controller;

use \TastyRecipes\Model\Recipe;
use \TastyRecipes\Integration\Cookbook;
use \TastyRecipes\Integration\Datastore;

class RecipeController {
    private $cookbook;

    public function __construct(string $data_directory) {
        $this->cookbook = new Cookbook($data_directory);
    }

    public function findRecipeByName(string $name) {
        return $this->cookbook->findRecipeByName($name);
    }

    public function getComments(Recipe $recipe) {
        $datastore = Datastore::getInstance();
        $comments = $datastore->findCommentsByRecipeName($recipe->getName());
        return $comments;
    }
}
