<?php
namespace TastyRecipes\Controller;

use \TastyRecipes\Model\User;
use \TastyRecipes\Model\Comment;
use \TastyRecipes\Model\ValidationException;
use \TastyRecipes\Integration\Datastore;

class CommentController {
    private $poster;

    public function __construct(User $user) {
        $this->poster = $user;
    }

    public function post(string $recipe_name, string $content) {
        $store = Datastore::getInstance();
        $comment = new Comment($content, $this->poster, $recipe_name);
        $validate_result = $comment->validate();
        if (isset($validate_result))
            throw new ValidationException($validate_result);
        $store->saveComment($comment);
        return $comment;
    }

    public function findComment(int $id) {
        $store = Datastore::getInstance();
        return $store->findCommentById($id);
    }

    public function delete(Comment $comment) {
        $store = Datastore::getInstance();
        $store->deleteCommentAs($this->poster, $comment);
    }
}
