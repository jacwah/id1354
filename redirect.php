<?php
function redirect($target, $status=303) {
    header("Location: $target", true, $status);
    die();
}
