<?php
require_once 'db.php';
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
        <?php echo $comment['content'] ?>
        <?php if ($comment['poster_id'] === $current_user['id']): ?>
        <form action="/delete_comment.php" method="post">
            <input type="hidden" name="id" value="<?php echo $comment['id'] ?>"/>
            <input type="submit" value="Delete"/>
        </form>
        <?php endif ?>
    </div>
<?php endforeach ?>
