<?php
require_once 'user.php';
require_once 'redirect.php';
require_once 'db.php';
$commentid = $_POST['id'];

if ($current_user && $commentid) {
    $conn = db_connect();
    $real_id = (int)$commentid;
    $escaped_current_user = mysqli_real_escape_string($conn, $current_user);
    $select_query = 'SELECT recipe_name FROM RecipeComment ' .
        "WHERE comment_id = $real_id;";
    $select_result = mysqli_query($conn, $select_query);
    if ($select_result) {
        $recipe_name = $select_result->fetch_assoc()['recipe_name'];
        $select_result->free();
    }
    $delete_query = 'DELETE RecipeComment FROM RecipeComment ' .
        'JOIN SiteUser ON poster_id = user_id ' .
        "WHERE comment_id = $real_id " .
        "AND username = \"$escaped_current_user\";";
    $delete_result = mysqli_query($conn, $delete_query);
    if (!$delete_result) {
        error_log("Failed to delete comment $real_id: " . mysqli_error($conn));
        $error = 1;
    }
    if (mysqli_affected_rows($conn) < 1) {
        error_log('No rows affected');
        $error = 1;
    }
} else {
    error_log('delete_comment.php without required parameters');
    $error = 1;
}

if (!$recipe_name)
    redirect('/');
else if ($error)
    redirect("/recipe.php?name=$recipe_name&comment=delete_failed#comments");
else
    redirect("/recipe.php?name=$recipe_name&comment=deleted#comments");
?>
