<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'fragments/common-head.html'?>
        <link rel="stylesheet" type="text/css" href="/style/recipe.css"/>
        <title><?= $recipe->getTitle() ?> recipe</title>
    </head>
    <body>
        <?php require 'fragments/navbar.php'?>
        <main>
            <h1><?= $recipe->getTitle() ?></h1>
            <img alt="Picture of <?= $recipe->getTitle() ?>" class="recipe-illustration" src="<?= $recipe->getImagePath() ?>"/>
            <p>Recipe and picture taken from <a href="<?= $recipe->getSourceUrl() ?>"/><?= $recipe->getSourceUrl() ?></a>.</p>
            <h2>Ingredients</h2>
            <ul class="ingredients">
                <?php foreach ($recipe->getIngredients() as $ingredient): ?>
                <li><?= $ingredient ?></li>
                <?php endforeach ?>
            </ul>
            <h2>Directions</h2>
            <ol class="directions">
                <?php foreach ($recipe->getDirections() as $step): ?>
                <li><?= $step ?></li>
                <?php endforeach ?>
            </ol>
            <h2>Comments</h2>
            <div id="comments">
            <?php require 'fragments/comments.php' ?>
            </div>
        </main>
    </body>
</html>
