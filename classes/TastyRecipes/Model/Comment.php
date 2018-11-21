<?php
namespace TastyRecipes\Model;

class Comment {
    private $id;
    private $content;
    private $poster;
    private $recipeName;

    public const MIN_LENGTH = 3;
    public const MAX_LENGTH = 500;

    public const CONTENT_TOO_SHORT = 1;
    public const CONTENT_TOO_LONG = 2;
    public const INVALID_RECIPE_NAME = 3;

    public function __construct(string $content, User $poster, string $recipe_name, int $id = 0) {
        $this->content = $content;
        $this->poster = $poster;
        $this->recipeName = $recipe_name;
        if ($id > 0)
            $this->id = (int)$id;
    }

    public function validate() {
        $content_len = strlen($this->content);
        if ($content_len < self::MIN_LENGTH)
            return self::CONTENT_TOO_SHORT;
        if ($content_len > self::MAX_LENGTH)
            return self::CONTENT_TOO_LONG;
        if (empty($this->recipeName) || !ctype_alpha($this->recipeName))
            return self::INVALID_RECIPE_NAME;
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
