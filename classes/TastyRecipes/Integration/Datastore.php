<?php
namespace TastyRecipes\Integration;

use \TastyRecipes\Model\User;
use \TastyRecipes\Model\Comment;
use \TastyRecipes\Model\Password;

class Datastore {
    private static $instance;
    private $conn;

    private function __construct() {
        $this->conn = new SqlConnection();
    }

    public static function getInstance() {
        if (!isset(static::$instance))
            static::$instance = new static();
        return static::$instance;
    }

    public function findCommentsByRecipeName(string $recipe_name) {
        $escaped_recipe_name = $this->conn->escape($recipe_name);
        $query = 'SELECT poster_id, username, content, comment_id ' .
            "FROM RecipeComment " .
            'JOIN SiteUser ON poster_id = user_id ' .
            "WHERE recipe_name = '$escaped_recipe_name';";
        $result = $this->conn->query($query);
        $comments = [];
        foreach ($result as $row) {
            $poster = new User($row['poster_id'], $row['username']);
            $comment = new Comment($row['content'], $poster, $recipe_name, $row['comment_id']);
            $comments[] = $comment;
        }
        $result->free();
        return $comments;
    }

    public function saveComment(Comment $comment) {
        $user_id = (int)$comment->getPoster()->getId();
        $escaped_recipe_name = $this->conn->escape($comment->getRecipeName());
        $escaped_content = $this->conn->escape($comment->getContent());
        $query = 'INSERT INTO RecipeComment (poster_id, recipe_name, content) VALUES ' .
            "($user_id, '$escaped_recipe_name', '$escaped_content');";
        $this->conn->query($query);
        $id = $this->conn->lastInsertId();
        $comment->setId($id);
    }

    public function findCommentById(int $comment_id) {
        $query = 'SELECT user_id, username, content, recipe_name ' .
            'FROM RecipeComment, SiteUser ' .
            "WHERE poster_id = user_id AND comment_id = $comment_id";
        $row = $this->conn->selectOne($query);
        $poster = new User((int)$row['user_id'], $row['username']);
        $comment = new Comment($row['content'], $poster, $row['recipe_name'], $comment_id);
        return $comment;
    }

    public function deleteCommentAsUser(User $user, Comment $comment) {
        $user_id = (int)$user->getId();
        $comment_id = (int)$comment->getId();
        $query = 'DELETE FROM RecipeComment ' .
            "WHERE comment_id = $comment_id " .
            "AND poster_id = $user_id;";
        $this->conn->queryAndExpectAffectedRows($query);
    }

    public function saveSession(User $user, string $session_id) {
        $user_id = (int)$user->getId();
        $escaped_session_id = $this->conn->escape($session_id);
        $query = 'INSERT INTO UserSession (user_id, session_id) ' .
            "VALUES ($user_id, '$escaped_session_id');";
        $this->conn->query($query);
    }

    public function findUserByName(string $name) {
        $escaped_name = $this->conn->escape($name);
        $query = 'SELECT user_id FROM SiteUser ' .
            "WHERE username = '$escaped_name';";
        try {
            $row = $this->conn->selectOne($query);
        } catch (NoResultException $e) {
            throw new UserNotFoundException();
        }
        return new User((int)$row['user_id'], $name);
    }

    public function findUserBySessionId(string $session_id) {
        $escaped_session_id = $this->conn->escape($session_id);
        $query = 'SELECT UserSession.user_id, username FROM UserSession ' .
            'JOIN SiteUser ON UserSession.user_id = SiteUser.user_id ' .
            "WHERE session_id = '$escaped_session_id';";
        try {
            $row = $this->conn->selectOne($query);
        } catch (NoResultException $e) {
            throw new UserNotFoundException();
        }
        return new User((int)$row['user_id'], $row['username']);
    }

    public function deleteSession(string $session_id) {
        $escaped_session_id = $this->conn->escape($session_id);
        $query = 'DELETE FROM UserSession WHERE ' .
            "session_id = '$escaped_session_id';";
        $this->conn->queryAndExpectAffectedRows($query);
    }

    public function findUserPasswordByName(string $username) {
        $escaped_username = $this->conn->escape($username);
        $query = 'SELECT password_hash FROM SiteUser ' .
            "WHERE username = '$escaped_username';";
        try {
            $row = $this->conn->selectOne($query);
        } catch (NoResultException $e) {
            throw new UserNotFoundException();
        }
        return Password::fromHash($row['password_hash']);
    }

    public function createUser(string $username, Password $password) {
        $escaped_username = $this->conn->escape($username);
        $escaped_password = $this->conn->escape($password->getHash());
        $query = 'INSERT INTO SiteUser (username, password_hash) VALUES ' .
            "('$escaped_username', '$escaped_password');";
        try {
            $this->conn->insertUnique($query);
        } catch (NotUniqueException $e) {
            throw new NameTakenException();
        }
    }
}
