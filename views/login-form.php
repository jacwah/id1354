<?php if (isset($_GET['registered'])): ?>
<p class="status-success">
    User registered.
</p>
<?php endif ?>
<?php if (isset($logged_out)): ?>
<p class="status-success">
    Logged out.
</p>
<?php endif ?>
<?php if (!empty($error)): ?>
<p class="status-error"><?= $error ?>.</p>
<?php endif ?>
<div class="note">
    <p>Note: this site uses cookies to authenticate logged in users.</p>
</div>
<form action="/login" method="post" class="user-password">
    <?php require 'fragments/user-password-fields.html' ?>
    <div class="inputgroup">
        <input type="submit" value="Login"/>
    </div>
</form>
<p>Not a member yet? <a href="/register">Register</a> today!</p>
