<?php foreach($comments as $comment): ?>
<div class="comment" id="comment-<?= $comment->getId() ?>">
    <span class="username"><?= $comment->getPoster()->getName() ?></span>
    <span class="content"> <?= $comment->getContent() ?></span>
    <?php if (isset($user_cntr) && $comment->getPoster()->equals($user_cntr->getUser())): ?>
    <form action="/delete-comment" method="post">
        <input type="hidden" name="id" value="<?= $comment->getId() ?>"/>
        <input type="submit" value="Delete" class="delete-comment"/>
    </form>
    <?php endif ?>
</div>
<?php endforeach ?>
<?php if (!empty($error)): ?>
<p class="status-error" id="comment-error"><?= $error ?></p>
<script>document.location.hash = 'comment-error';</script>
<?php endif ?>
<?php if (isset($user_cntr)): ?>
<form action="/recipe" method="post" class="comment">
    <input type="hidden" name="name" value="<?= $recipe_name ?>"/>
    <span class="username"><?= $user_cntr->getUser()->getName() ?></span>
    <textarea name="content" class="content" required></textarea>
    <input type="submit" value="Post"/>
</form>
<?php else: ?>
<p><a href="/login">Log in</a> to comment.</p>
<?php endif ?>
