<?php
namespace TastyRecipes\Integration;

use \TastyRecipes\Model\User;
use \TastyRecipes\Model\Comment;

class Datastore {
    private const ERROR_DUPLICATE_ENTRY = 1062;

    private static $instance;
    private $conn;

    private function __construct() {
        $this->conn = mysqli_connect('127.0.0.1', 'app', '123', 'tasty_recipes', NULL, NULL);
        if (!$this->conn)
            error_log('Failed to connect to database');
    }

    public static function getInstance() {
        if (!isset(static::$instance))
            static::$instance = new static();
        return static::$instance;
    }

    private function query(string $query) {
        error_log("Executing: $query");
        $result = mysqli_query($this->conn, $query);
        if (!$result) {
            error_log('Query failed: ' . mysqli_error($this->conn));
        }
        return $result;
    }

    private function escape(string $s) {
        return mysqli_real_escape_string($this->conn, $s);
    }

    private function lastInsertId() {
        return mysqli_insert_id($this->conn);
    }

    public function connected() {
        return (bool)$this->conn;
    }

    public function succeeded() {
        return mysqli_errno($this->conn) === 0;
    }

    public function loadComments(string $recipe_name) {
        if (!$this->connected())
            return [];
        $escaped_recipe_name = $this->escape($recipe_name);
        $query = 'SELECT poster_id, username, content, comment_id ' .
            "FROM RecipeComment " .
            'JOIN SiteUser ON poster_id = user_id ' .
            "WHERE recipe_name = \"$escaped_recipe_name\";";
        $result = $this->query($query);
        $comments = [];
        if ($result) {
            foreach ($result as $row) {
                $poster = new User($row['poster_id'], $row['username']);
                $comment = new Comment($row['content'], $poster, $recipe_name, $row['comment_id']);
                $comments[] = $comment;
            }
            $result->free();
        }
        return $comments;
    }

    public function addComment(User $poster, string $recipe_name, string $content) {
        $user_id = $poster->getId();
        $escaped_recipe_name = $this->escape($recipe_name);
        $escaped_content = $this->escape($content);
        $query = 'INSERT INTO RecipeComment (poster_id, recipe_name, content) VALUES ' .
            "($user_id, \"$escaped_recipe_name\", \"$escaped_content\");";
        $result = $this->query($query);
        if ($result) {
            $id = $this->lastInsertId();
            return new Comment($content, $poster, $recipe_name, $id);
        }
        throw new DatastoreException();
    }

    public function getRecipeNameFromComment(int $comment_id) {
        $query = 'SELECT recipe_name FROM RecipeComment ' .
            "WHERE comment_id = $comment_id;";
        $result = $this->query($query);
        if ($result) {
            $row = $result->fetch_row();
            if (isset($row))
                $recipe_name = $row[0];
            $result->free();
        }
        return $recipe_name;
    }

    public function findCommentById(int $comment_id) {
        $query = 'SELECT user_id, username, content, recipe_name ' .
            'FROM RecipeComment, SiteUser ' .
            'WHERE poster_id = user_id AND comment_id = ' . $comment_id;
        $result = $this->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row)) {
                $poster = new User((int)$row['user_id'], $row['username']);
                return new Comment($row['content'], $poster, $row['recipe_name'], $comment_id);
            }
        }
        throw new DatastoreException();
    }

    public function deleteCommentAs(User $user, Comment $comment) {
        $user_id = $user->getId();
        $comment_id = $comment->getId();
        $query = 'DELETE FROM RecipeComment ' .
            "WHERE comment_id = $comment_id " .
            "AND poster_id = $user_id;";
        $result = $this->query($query);
        if (!$result || mysqli_affected_rows($this->conn) < 1) {
            throw new DatastoreException();
        }
    }

    public function getUsername(int $user_id) {
        $query = 'SELECT username FROM SiteUser ' .
            "WHERE user_id = $user_id;";
        $result = $this->query($query);
        if ($result) {
            $row = $result->fetch_row();
            if (isset($row)) {
                $username = $row[0];
            }
            $result->free();
        }
        return $username;
    }

    public function saveSession(User $user, string $session_id) {
        $user_id = $user->getId();
        $escaped_session_id = $this->escape($session_id);
        $query = 'INSERT INTO UserSession (user_id, session_id) ' .
            "VALUES ($user_id, \"$escaped_session_id\");";
        return $this->query($query);
    }

    public function getUserBySessionId(string $session_id) {
        $escaped_session_id = $this->escape($session_id);
        $query = 'SELECT UserSession.user_id, username FROM UserSession ' .
            'JOIN SiteUser ON UserSession.user_id = SiteUser.user_id ' .
            "WHERE session_id = \"$escaped_session_id\";";
        $result = $this->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row)) {
                $user = new User((int)$row['user_id'], $row['username']);
            }
            $result->free();
        }
        if (isset($user))
            return $user;
        else
            throw new UserNotFoundException();
    }

    public function deleteSession(string $session_id) {
        $escaped_session_id = $this->escape($session_id);
        $query = 'DELETE FROM UserSession WHERE ' .
            "session_id = \"$escaped_session_id\";";
        return $this->query($query);
    }

    public function getUserWithPassword(string $username, string $password) {
        $escaped_username = $this->escape($username);
        $escaped_password = $this->escape($password);
        $query = 'SELECT user_id FROM SiteUser ' .
            "WHERE username = \"$escaped_username\" AND password = \"$escaped_password\";";
        $result = $this->query($query);
        if ($result) {
            $row = $result->fetch_row();
            if (isset($row)) {
                $user = new User($row[0], $username);
            }
            $result->free();
        }
        if (isset($user))
            return $user;
        else
            throw new UserNotFoundException();
    }

    public function createUser(string $username, string $password) {
        $escaped_username = $this->escape($username);
        $escaped_password = $this->escape($password);
        $query = 'INSERT INTO SiteUser (username, password) VALUES ' .
            "(\"$escaped_username\", \"$escaped_password\");";
        $result = $this->query($query);
        if (!$result) {
            if (mysqli_errno($this->conn) === static::ERROR_DUPLICATE_ENTRY)
                throw new NameTakenException();
            else
                throw new DatastoreException();
        }
    }
}
