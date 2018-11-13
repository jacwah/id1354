<?php
require_once 'lib/db.php';
require_once 'lib/user.php';
$comments = $db->loadComments($recipe_name);
?>
<?php if ($_GET['comment'] === 'delete_failed'): ?>
<p class="status">
Failed to delete comment. Please try again later!
</p>
<?php elseif ($_GET['comment'] === 'create_failed'): ?>
<p class="status">
Failed to add comment. Please try again later!
</p>
<?php elseif ($_GET['comment'] === 'deleted'): ?>
<p class="status">
Comment succesfully deleted.
</p>
<?php endif ?>
<?php foreach($comments as $comment): ?>
    <div class="comment" id="comment-<?php echo $comment['id'] ?>">
        <span class="username"><?php echo $comment['username']?></span>
        <span class="content"> <?php echo $comment['content'] ?></span>
        <?php if ($comment['poster_id'] === $current_user['id']): ?>
        <form action="/delete-comment.php" method="post">
            <input type="hidden" name="id" value="<?php echo $comment['id'] ?>"/>
            <input type="submit" value="Delete" class="delete-comment"/>
        </form>
        <?php endif ?>
    </div>
<?php endforeach ?>
<?php if (isset($current_user)): ?>
<form action="/comment.php" method="post" class="comment">
    <input type="hidden" name="recipe_name" value="<?= $recipe_name ?>"/>
    <span class="username"><?= $current_user['name'] ?></span>
    <textarea name="content" class="content" required></textarea>
    <input type="submit" value="Post"/>
</form>
<?php else: ?>
<p><a href="/login.php">Log in</a> to comment.</p>
<?php endif ?>
