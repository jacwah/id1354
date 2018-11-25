<?php
namespace TastyRecipes\View;

class RenderContext {
    private $vars = array();

    public function set(string $key, $value) {
        $this->vars[$key] = $value;
    }

    public function render(string $view_name) {
        foreach ($this->vars as $key => $val)
            $$key = $val;
        require 'views/' . $view_name . '.php';
    }
}
