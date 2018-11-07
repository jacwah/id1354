<?php
$cookbook = simplexml_load_file('cookbook.xml');
$title = ucfirst($_GET['name']);
$recipe = $cookbook->xpath('/cookbook/recipe[title="' . $title . '"]')[0];

function echoList($list) {
    foreach($list as $li) {
        echo '<li>', $li, '</li>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'fragments/common-head.html'?>
        <link rel="stylesheet" type="text/css" href="/style/recipe.css"/>
        <title><?php echo $recipe->title ?> recipe</title>
    </head>
    <body>
        <?php include 'fragments/navbar.html'?>
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
            <div class="comments">
                <div class="comment">
                    <span class="username">jacob98</span> I wouldn't bother making these, Mama Scan's are better.
                </div>
            </div>
        </main>
    </body>
</html>
