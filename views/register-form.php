<?php if (!empty($error)): ?>
<p class="status-error"><?= $error ?>.</p>
<?php endif ?>
<form action="/register" method="post" class="user-password">
    <?php require 'fragments/user-password-fields.html' ?>
    <div class="inputgroup">
        <input type="submit" value="Register"/>
    </div>
</form>
<p>Already a member? <a href="/login">Log in</a> instead.</p>
