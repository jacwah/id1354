<?php
namespace TastyRecipes\Controller;

use \TastyRecipes\Model\User;
use \TastyRecipes\Model\Comment;
use \TastyRecipes\Model\Recipe;
use \TastyRecipes\Model\ValidationException;
use \TastyRecipes\Integration\Datastore;

class CommentController {
    private $poster;

    public function __construct(User $user) {
        $this->poster = $user;
    }

    public function post(Recipe $recipe, string $content) {
        $comment = new Comment($content, $this->poster, $recipe->getName());
        $validate_result = $comment->validate();
        if (isset($validate_result))
            throw new ValidationException($validate_result);
        $store = Datastore::getInstance();
        $store->saveComment($comment);
        return $comment;
    }

    public function findComment(int $id) {
        $store = Datastore::getInstance();
        return $store->findCommentById($id);
    }

    public function delete(Comment $comment) {
        $store = Datastore::getInstance();
        $store->deleteCommentAsUser($this->poster, $comment);
    }
}
