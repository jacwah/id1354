<?php
namespace TastyRecipes\View;

class Json {
    public static function write(array $data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
