<?php $ctx->renderFragment('status') ?>
<?php $ctx->renderFragment('user-password-form', ['action' => '/register', 'submit' => 'Register']) ?>
<p>Already a member? <a href="/login">Log in</a> instead.</p>
