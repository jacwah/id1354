<?php
const NUM_SESSION_BYTES = 16;
const SESSION_LEN = NUM_SESSION_BYTES * 2;

class Database {
    private $conn;

    public function __construct() {
        $this->conn = mysqli_connect('127.0.0.1', 'app', '123', 'tasty_recipes', NULL, NULL);
        if (!$this->conn)
            error_log('Failed to connect to database');
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

    private static function generateSessionId() {
        return bin2hex(random_bytes(NUM_SESSION_BYTES));
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
                $comment = [
                    'username' => $row['username'],
                    'content' => $row['content'],
                    'id' => $row['comment_id'],
                    'poster_id' => $row['poster_id']
                ];
                $comments[] = $comment;
            }
            $result->free();
        }
        return $comments;
    }

    public function addComment(int $user_id, string $recipe_name, string $content) {
        $escaped_recipe_name = $this->escape($recipe_name);
        $escaped_content = $this->escape($content);
        $query = 'INSERT INTO RecipeComment (poster_id, recipe_name, content) VALUES ' .
            "($user_id, \"$escaped_recipe_name\", \"$escaped_content\");";
        $result = $this->query($query);
        if ($result) {
            $comment_id = $this->lastInsertId();
        }
        return $comment_id;
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

    public function deleteComment(int $poster_id, int $comment_id) {
        $query = 'DELETE FROM RecipeComment ' .
            "WHERE comment_id = $comment_id " .
            "AND poster_id = $poster_id;";
        $result = $this->query($query);
        if (!$result || mysqli_affected_rows($this->conn) < 1) {
            error_log("Failed to delete comment with id $comment_id for user with id $poster_id");
            return FALSE;
        } else {
            return TRUE;
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

    public function createSession(int $user_id) {
        $session_id = static::generateSessionId();
        $escaped_session_id = $this->escape($session_id);
        $query = 'INSERT INTO UserSession (user_id, session_id) ' .
            "VALUES ($user_id, \"$escaped_session_id\");";
        if ($this->query($query))
            return ['id' => $session_id, 'user_id' => $user_id, 'username' => $this->getUsername($user_id)];
        else
            return NULL;
    }

    public function getSession(string $session_id) {
        $escaped_session_id = $this->escape($session_id);
        $query = 'SELECT UserSession.user_id, username FROM UserSession ' .
            'JOIN SiteUser ON UserSession.user_id = SiteUser.user_id ' .
            "WHERE session_id = \"$escaped_session_id\";";
        $result = $this->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            if (isset($row)) {
                $session = [
                    'id' => $session_id,
                    'username' => $row['username'],
                    'user_id' => $row['user_id']
                ];
            }
            $result->free();
        }
        return $session;
    }

    public function deleteSession(string $session_id) {
        $escaped_session_id = $this->escape($session_id);
        $query = 'DELETE FROM UserSession WHERE ' .
            "session_id = \"$escaped_session_id\";";
        return $this->query($query);
    }

    public function userIdIfPasswordOk(string $username, string $password) {
        $escaped_username = $this->escape($username);
        $escaped_password = $this->escape($password);
        $query = 'SELECT user_id FROM SiteUser ' .
            "WHERE username = \"$escaped_username\" AND password = \"$escaped_password\";";
        $result = $this->query($query);
        if ($result) {
            $row = $result->fetch_row();
            if (isset($row))
                $user_id = $row[0];
            $result->free();
        }
        return $user_id;
    }

    public function registerUser(string $username, string $password) {
        $escaped_username = $this->escape($username);
        $escaped_password = $this->escape($password);
        $query = 'INSERT INTO SiteUser (username, password) VALUES ' .
            "(\"$escaped_username\", \"$escaped_password\");";
        $result = $this->query($query);
        if (!$result) {
            if (mysqli_errno($this->conn) === 1062)
                return "That name is already taken";
            else
                return "Unexpected error";
        }
    }
}

$db = new Database();
