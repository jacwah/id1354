<?php
function db_connect() {
    return mysqli_connect('127.0.0.1', 'app', '123', 'tasty_recipes', NULL, NULL);
}
?>
