<?php
function redirect($target) {
    header("Location: $target", true, 303);
    die();
}
?>
