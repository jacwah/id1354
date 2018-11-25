<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'fragments/common-head.html'?>
        <?php if (isset($page_style)): ?>
        <link rel="stylesheet" type="text/css" href="<?= $page_style ?>"/>
        <?php endif ?>
        <title><?= $page_name . ' | ' . $site_name ?></title>
    </head>
    <body>
        <?php require 'fragments/navbar.php'?>
        <main>
            <h1><?= $page_name ?></h1>
            <?php $this->renderView($view) ?>
        </main>
    </body>
</html>
