<?php
namespace TastyRecipes\Integration;

use \TastyRecipes\Model\Recipe;

class Cookbook {
    private const FILENAME = 'cookbook.xml';

    private $document;

    public function __construct(string $directory) {
        $this->document = simplexml_load_file($directory . '/' . static::FILENAME);
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
