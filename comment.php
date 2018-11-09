<?php
require_once 'user.php';
require_once 'redirect.php';
require_once 'db.php';
$recipe_name = $_POST['recipe_name'];
$content = $_POST['content'];

if ($current_user && $recipe_name && $content) {
    $conn = db_connect();
    if ($conn) {
        $escaped_recipe_name = mysqli_real_escape_string($conn, $recipe_name);
        $escaped_content = mysqli_real_escape_string($conn, $content);
        $escaped_current_user = mysqli_real_escape_string($conn, $current_user);
        $query = 'INSERT INTO RecipeComment (poster_id, recipe_name, content) SELECT ' .
            "user_id, \"$escaped_recipe_name\", \"$escaped_content\" " .
            "FROM SiteUser WHERE username = \"$escaped_current_user\";";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $comment_id = mysqli_insert_id($conn);
        } else {
            error_log('Failed to add comment: ' . mysqli_error($conn));
            $error = 1;
        }
    } else {
        $error = 1;
    }
} else {
    error_log('comment.php without required parameters');
    $error = 1;
}

if (!$recipe_name)
    redirect('/');
else if ($error)
    redirect("/recipe.php?name=$recipe_name&comment=create_failed#comments");
else if ($comment_id)
    redirect("/recipe.php?name=$recipe_name#comment-$comment_id");
else
    redirect("/recipe.php?name=$recipe_name#comments");
?>
