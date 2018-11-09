<?php
require_once 'user.php';
require_once 'redirect.php';
require_once 'db.php';
$recipe_name = $_POST['recipe_name'];
$content = $_POST['content'];

if ($current_user && $recipe_name && $content) {
    $conn = db_connect();
    if ($conn) {
        $comment_id = db_add_comment($conn, $current_user['id'], $recipe_name, $content);
        if (!isset($comment_id)) {
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
