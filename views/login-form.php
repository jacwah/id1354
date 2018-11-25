<?php $ctx->renderFragment('status') ?>
<div class="note">
    <p>Note: this site uses cookies to authenticate logged in users.</p>
</div>
<?php $ctx->renderFragment('user-password-form', ['action' => '/login', 'submit' => 'Login']) ?>
<p>Not a member yet? <a href="/register">Register</a> today!</p>
