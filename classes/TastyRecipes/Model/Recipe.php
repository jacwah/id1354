<?php
namespace TastyRecipes\Model;

class Recipe {
    private $name;
    private $title;
    private $sourceUrl;
    private $imagePath;
    private $ingredients;
    private $directions;

    public function __construct(
        string $name,
        string $title,
        string $source_url,
        string $image_path,
        array $ingredients,
        array $directions)
    {
        $this->name = $name;
        $this->title = $title;
        $this->sourceUrl = $source_url;
        $this->imagePath = $image_path;
        $this->ingredients = $ingredients;
        $this->directions = $directions;
    }

    public function getName() {
        return $this->name;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getSourceUrl() {
        return $this->sourceUrl;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function getIngredients() {
        return $this->ingredients;
    }

    public function getDirections() {
        return $this->directions;
    }
}
