<?php
namespace TastyRecipes\Integration;

use \TastyRecipes\Model\Recipe;

class Cookbook {
    private $document;

    public function __construct() {
        $this->document = simplexml_load_file('cookbook.xml');
    }

    public function findRecipeByName(string $name) {
        $xpath = "/cookbook/recipe[url=\"$name\"]";
        $recipeEl = $this->document->xpath($xpath)[0];
        return new Recipe(
            $name,
            $recipeEl->title,
            $recipeEl->source,
            $recipeEl->imagepath,
            (array)$recipeEl->ingredient->li,
            (array)$recipeEl->recipetext->li);
    }
}
