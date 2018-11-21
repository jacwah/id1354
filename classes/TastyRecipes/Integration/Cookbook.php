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
            iterator_to_array($recipeEl->ingredient->li),
            iterator_to_array($recipeEl->recipetext->li));
    }
}
