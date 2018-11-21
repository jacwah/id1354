<?php
namespace TastyRecipes\Model;

class Comment {
    private $id;
    private $content;
    private $poster;
    private $recipeName;

    public function __construct(string $content, User $poster, string $recipe_name, $id) {
        $this->content = $content;
        $this->poster = $poster;
        $this->recipeName = $recipe_name;
        if (isset($id))
            $this->id = (int)$id;
    }

    public function getContent() {
        return $this->content;
    }

    public function getPoster() {
        return $this->poster;
    }

    public function getRecipename() {
        return $this->recipeName;
    }

    public function getId() {
        if (isset($this->id))
            return $this->id;
        else
            throw new NoIdException();
    }

    public function setId(int $id) {
        $this->id = $id;
    }
}
