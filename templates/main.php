<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <?php foreach ($page_style as $href): ?>
        <link rel="stylesheet" type="text/css" href="<?= $href ?>"/>
        <?php endforeach ?>
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
