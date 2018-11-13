<?php
require_once 'lib/user.php';
require_once 'lib/http.php';
require_once 'lib/db.php';

$recipe_name = $_POST['recipe_name'];
$content = $_POST['content'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    http_response_code(HTTP_METHOD_NOT_ALLOWED);
else if (!$recipe_name || !$content)
    http_response_code(HTTP_UNPROCESSABLE);
else if (!$current_user)
    http_response_code(HTTP_FORBIDDEN);
else {
    if ($db->connected()) {
        $comment_id = $db->addComment($current_user['id'], $recipe_name, $content);
        if (!isset($comment_id)) {
            $error = 1;
        }
    } else {
        $error = 1;
    }
    $path = "/recipe.php?name=$recipe_name";
    if ($error)
        http_redirect($path . "&comment=create_failed#comments");
    else if ($comment_id)
        http_redirect($path . "#comment-$comment_id");
    else
        http_redirect($path . "#comments");
}
