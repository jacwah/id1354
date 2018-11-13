<?php
require_once 'lib/cookbook.php';
$recipe_name = $_GET['name'];
$recipe = cookbook_find($recipe_name);

if (!$recipe) {
    require_once 'lib/http.php';
    http_render_404();
}

function echoList($list) {
    foreach($list as $li) {
        echo '<li>', $li, '</li>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require 'fragments/common-head.html'?>
        <link rel="stylesheet" type="text/css" href="/style/recipe.css"/>
        <title><?php echo $recipe->title ?> recipe</title>
    </head>
    <body>
        <?php require 'fragments/navbar.php'?>
        <main>
            <h1><?php echo $recipe->title?></h1>
            <img alt="Picture of <?php echo $recipe->title?>" class="recipe-illustration" src="<?php echo $recipe->imagepath?>"/>
            <p>Recipe and picture taken from <a href="<?php echo $recipe->source?>"/><?php echo $recipe->source?></a>.</p>
            <h2>Ingredients</h2>
            <ul class="ingredients">
                <?php echoList($recipe->ingredient->li) ?>
            </ul>
            <h2>Directions</h2>
            <ol class="directions">
                <?php echoList($recipe->recipetext->li) ?>
            </ol>
            <h2>Comments</h2>
            <div id="comments">
            <?php require 'fragments/comments.php' ?>
            </div>
        </main>
    </body>
</html>
