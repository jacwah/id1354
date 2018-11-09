<?php
const NUM_SESSION_BYTES = 16;
const SESSION_LEN = NUM_SESSION_BYTES * 2;

function db_connect() {
    $conn = mysqli_connect('127.0.0.1', 'app', '123', 'tasty_recipes', NULL, NULL);
    if (!$conn)
        error_log('Failed to connect to database');
    return $conn;
}

function db_query($conn, $query) {
    error_log("Executing $query");
    $result = mysqli_query($conn, $query);
    if (!$result) {
        error_log('Query failed: ' . mysqli_error($conn));
    }
    return $result;
}

function db_load_comments(string $recipe_name) {
    $conn = db_connect();
    $escaped_recipe_name = mysqli_real_escape_string($conn, $recipe_name);
    $query = 'SELECT poster_id, username, content, comment_id ' .
        "FROM RecipeComment " .
        'JOIN SiteUser ON poster_id = user_id ' .
        "WHERE recipe_name = \"$escaped_recipe_name\";";
    $result = db_query($conn, $query);
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

function db_add_comment($conn, int $user_id, string $recipe_name, string $content) {
    $escaped_recipe_name = mysqli_real_escape_string($conn, $recipe_name);
    $escaped_content = mysqli_real_escape_string($conn, $content);
    $query = 'INSERT INTO RecipeComment (poster_id, recipe_name, content) VALUES ' .
        "($user_id, \"$escaped_recipe_name\", \"$escaped_content\");";
    $result = db_query($conn, $query);
    if ($result) {
        $comment_id = mysqli_insert_id($conn);
    }
    return $comment_id;
}

function db_get_username($conn, int $userid) {
    $query = 'SELECT username FROM SiteUser ' .
        "WHERE user_id = $userid;";
    $result = db_query($conn, $query);
    if ($result) {
        $row = $result->fetch_row();
        $username = $row[0];
        $result->free();
    }
    return $username;
}

function db_generate_session_id() {
    return bin2hex(random_bytes(NUM_SESSION_BYTES));
}

function db_create_session($conn, int $user_id) {
    $session_id = db_generate_session_id();
    $escaped_session_id = mysqli_real_escape_string($conn, $session_id);
    $query = 'INSERT INTO UserSession (user_id, session_id) ' .
        "VALUES ($user_id, \"$escaped_session_id\");";
    if (db_query($conn, $query))
        return ['id' => $session_id, 'user_id' => $user_id, 'username' => db_get_username($conn, $user_id)];
    else
        return NULL;
}


function db_get_session($conn, string $session_id) {
    $escaped_session_id = mysqli_real_escape_string($conn, $session_id);
    $query = 'SELECT UserSession.user_id, username FROM UserSession ' .
        'JOIN SiteUser ON UserSession.user_id = SiteUser.user_id ' .
        "WHERE session_id = \"$escaped_session_id\";";
    $result = db_query($conn, $query);
    if ($result) {
        $row = $result->fetch_assoc();
        $session = [
            'id' => $session_id,
            'username' => $row['username'],
            'user_id' => $row['user_id']
        ];
        $result->free();
    }
    return $session;
}

function db_delete_session($conn, string $session_id) {
    $escaped_session_id = mysqli_real_escape_string($conn, $session_id);
    $query = 'DELETE FROM UserSession WHERE' .
        "session_id = \"$escaped_session_id\";";
    return db_query($conn, $query);
}
?>
