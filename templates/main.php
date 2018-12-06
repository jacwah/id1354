<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <?php foreach ($page_style as $href): ?>
        <link rel="stylesheet" type="text/css" href="<?= $href ?>"/>
        <?php endforeach ?>
        <link rel="stylesheet" type="text/css" href="/style/logged-in.css" id="logged-in-link"/>
        <link rel="stylesheet" type="text/css" href="/style/logged-out.css" id="logged-out-link"/>
        <?php if ($current_user): ?>
        <meta name="username" content="<?= $current_user->getName() ?>"/>
        <?php endif ?>
        <script src="/scripts/user.js"></script>
        <title>
            <?php if (!empty($page_name)): ?>
            <?= $page_name . ' | ' . $site_name ?>
            <?php else: ?>
            <?= $site_name ?>
            <?php endif ?>
        </title>
    </head>
    <body>
        <?php $ctx->renderFragment('navbar') ?>
        <main>
            <h1>
                <?php if (!empty($page_name)): ?>
                <?= $page_name ?>
                <?php else: ?>
                <?= $site_name ?>
                <?php endif ?>
            </h1>
            <?php $ctx->renderView($ctx_view) ?>
        </main>
    </body>
</html>
