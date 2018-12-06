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
</div>
<div id="post-comment" class="logged-in">
    <span class="username"></span>
    <textarea name="content" class="content" required></textarea>
    <button id="post-comment-button">Post</button>
</div>
