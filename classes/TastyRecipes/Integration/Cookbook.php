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
        // Avoid xpath injection
        if (ctype_alnum($name)) {
            $xpath = "/cookbook/recipe[url=\"$name\"]";
            $match = $this->document->xpath($xpath);
            if ($match) {
                $el = $match[0];
                return new Recipe(
                    $name,
                    $el->title,
                    $el->source,
                    $el->imagepath,
                    (array)$el->ingredient->li,
                    (array)$el->recipetext->li);
            }
        }
        throw new RecipeNotFoundException();
    }
}
