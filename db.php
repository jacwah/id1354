<?php
function db_connect() {
    $conn = mysqli_connect('127.0.0.1', 'app', '123', 'tasty_recipes', NULL, NULL);
    if (!$conn)
        error_log('Failed to connect to database');
    return $conn;
}

function db_load_comments($recipe_name) {
    $conn = db_connect();
    $escaped_recipe_name = mysqli_real_escape_string($conn, $recipe_name);
    $query = 'SELECT username, content, comment_id ' .
        "FROM RecipeComment " .
        'JOIN SiteUser ON poster_id = user_id ' .
        "WHERE recipe_name = \"$escaped_recipe_name\";";
    $result = mysqli_query($conn, $query);
    $comments = [];
    echo mysqli_error($conn);
    if ($result) {
        foreach ($result as $row) {
            $comment = [
                'username' => $row['username'],
                'content' => $row['content'],
                'id' => $row['comment_id']
            ];
            $comments[] = $comment;
        }
        $result->free();
    }
    return $comments;
}
?>
