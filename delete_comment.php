<?php
require_once 'user.php';
require_once 'redirect.php';
require_once 'db.php';
$comment_id = (int)$_POST['id'];
$error = TRUE;

if (isset($current_user) && isset($comment_id)) {
    $user_id = $current_user['id'];
    if ($db->connected()) {
        $recipe_name = $db->getRecipeNameFromComment($comment_id);
        if (isset($recipe_name)) {
            if ($db->deleteComment($user_id, $comment_id)) {
                $error = FALSE;
            }
        }
    }
} else {
    error_log('delete_comment.php without required parameters');
}

if (!isset($recipe_name))
    redirect('/');
else if ($error)
    redirect("/recipe.php?name=$recipe_name&comment=delete_failed#comments");
else
    redirect("/recipe.php?name=$recipe_name&comment=deleted#comments");
?>
