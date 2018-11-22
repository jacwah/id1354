<?php
namespace TastyRecipes\Integration;

use \TastyRecipes\Model\User;
use \TastyRecipes\Model\Comment;
use \TastyRecipes\Model\Password;

class Datastore {
    private const ERROR_DUPLICATE_ENTRY = 1062;

    private static $instance;
    private $conn;

    private function __construct() {
        $this->conn = mysqli_connect('127.0.0.1', 'app', '123', 'tasty_recipes', NULL, NULL);
        if (!$this->conn) {
            error_log('Failed to connect to database');
            throw new DatastoreException('Failed to connect to database');
        }
    }

    public static function getInstance() {
        if (!isset(static::$instance))
            static::$instance = new static();
        return static::$instance;
    }

    private function query(string $query) {
        error_log("Executing: $query");
        $result = mysqli_query($this->conn, $query);
        if (!$result)
            throw new DatastoreException('Query failed: ' . mysqli_error($this->conn));
        return $result;
    }

    private function selectOne(string $query) {
        $result = $this->query($query);
        $row = $result->fetch_assoc();
        $result->free();
        if (isset($row))
            return $row;
        else
            throw new DatastoreException('Expected one row, got none');
    }

    private function queryAndExpectAffectedRows(string $query) {
        $this->query($query);
        if (mysqli_affected_rows($this->conn) < 1)
            throw new DatastoreException('Expected affected rows, got none');
    }

    private function escape(string $s) {
        return mysqli_real_escape_string($this->conn, $s);
    }

    private function lastInsertId() {
        return mysqli_insert_id($this->conn);
    }

    public function findCommentsByRecipeName(string $recipe_name) {
        $escaped_recipe_name = $this->escape($recipe_name);
        $query = 'SELECT poster_id, username, content, comment_id ' .
            "FROM RecipeComment " .
            'JOIN SiteUser ON poster_id = user_id ' .
            "WHERE recipe_name = '$escaped_recipe_name';";
        $result = $this->query($query);
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
        $user_id = $comment->getPoster()->getId();
        $escaped_recipe_name = $this->escape($comment->getRecipeName());
        $escaped_content = $this->escape($comment->getContent());
        $query = 'INSERT INTO RecipeComment (poster_id, recipe_name, content) VALUES ' .
            "($user_id, '$escaped_recipe_name', '$escaped_content');";
        $this->query($query);
        $id = $this->lastInsertId();
        $comment->setId($id);
    }

    public function findCommentById(int $comment_id) {
        $query = 'SELECT user_id, username, content, recipe_name ' .
            'FROM RecipeComment, SiteUser ' .
            "WHERE poster_id = user_id AND comment_id = $comment_id";
        $row = $this->selectOne($query);
        $poster = new User((int)$row['user_id'], $row['username']);
        $comment = new Comment($row['content'], $poster, $row['recipe_name'], $comment_id);
        return $comment;
    }

    public function deleteCommentAsUser(User $user, Comment $comment) {
        $user_id = $user->getId();
        $comment_id = $comment->getId();
        $query = 'DELETE FROM RecipeComment ' .
            "WHERE comment_id = $comment_id " .
            "AND poster_id = $user_id;";
        $this->queryAndExpectAffectedRows($query);
    }

    public function saveSession(User $user, string $session_id) {
        $user_id = $user->getId();
        $escaped_session_id = $this->escape($session_id);
        $query = 'INSERT INTO UserSession (user_id, session_id) ' .
            "VALUES ($user_id, '$escaped_session_id');";
        $this->query($query);
    }

    public function findUserByName(string $name) {
        $escaped_name = $this->escape($name);
        $query = 'SELECT user_id FROM SiteUser ' .
            "WHERE username = '$escaped_name';";
        $row = $this->selectOne($query);
        return new User((int)$row['user_id'], $name);
    }

    public function findUserBySessionId(string $session_id) {
        $escaped_session_id = $this->escape($session_id);
        $query = 'SELECT UserSession.user_id, username FROM UserSession ' .
            'JOIN SiteUser ON UserSession.user_id = SiteUser.user_id ' .
            "WHERE session_id = '$escaped_session_id';";
        $row = $this->selectOne($query);
        return new User((int)$row['user_id'], $row['username']);
    }

    public function deleteSession(string $session_id) {
        $escaped_session_id = $this->escape($session_id);
        $query = 'DELETE FROM UserSession WHERE ' .
            "session_id = '$escaped_session_id';";
        $this->queryAndExpectAffectedRows($query);
    }

    public function findUserPasswordByName(string $username) {
        $escaped_username = $this->escape($username);
        $query = 'SELECT password_hash FROM SiteUser ' .
            "WHERE username = '$escaped_username';";
        $row = $this->selectOne($query);
        return Password::fromHash($row['password_hash']);
    }

    public function createUser(string $username, Password $password) {
        $escaped_username = $this->escape($username);
        $escaped_password = $this->escape($password->getHash());
        $query = 'INSERT INTO SiteUser (username, password_hash) VALUES ' .
            "('$escaped_username', '$escaped_password');";
        try {
            $this->query($query);
        } catch (DatastoreException $e) {
            if (mysqli_errno($this->conn) === static::ERROR_DUPLICATE_ENTRY)
                throw new NameTakenException();
            else
                throw $e;
        }
    }
}
