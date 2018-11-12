<?php
function find_recipe($name) {
    $cookbook = simplexml_load_file('cookbook.xml');
    $xpath = "/cookbook/recipe[url=\"$name\"]";
    $recipe = $cookbook->xpath($xpath)[0];
    return $recipe;
}
