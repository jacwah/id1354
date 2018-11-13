<?php
require_once 'lib/user.php';
require_once 'lib/http.php';
require_once 'lib/db.php';

$comment_id = (int)$_POST['id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    http_response_code(HTTP_METHOD_NOT_ALLOWED);
else if (!$comment_id)
    http_response_code(HTTP_UNPROCESSABLE);
else if (!$current_user)
    http_response_code(HTTP_FORBIDDEN);
else {
    $user_id = $current_user['id'];
    $error = TRUE;
    if ($db->connected()) {
        $recipe_name = $db->getRecipeNameFromComment($comment_id);
        if ($recipe_name) {
            if ($db->deleteComment($user_id, $comment_id)) {
                $error = FALSE;
            }
        }
    }
    if (!$recipe_name)
        http_response_code(HTTP_INTERNAL_ERROR);
    else {
        if ($error)
            $status = 'delete_failed';
        else
            $status = 'deleted';
        http_redirect("/recipe.php?name=$recipe_name&comment=$status#comments");
    }
}
