<?php
namespace TastyRecipes\View;

class RenderContext {
    private $vars = array();
    private $template;

    public function __construct(string $template) {
        $this->template = $template;
    }

    public function set(string $key, $value) {
        $this->vars[$key] = $value;
    }

    public function add(string $key, $value) {
        $this->vars[$key][] = $value;
    }

    private function renderByPath(string $render_context_dir, string $render_context_name, array $render_context_vars) {
        foreach (array_merge($render_context_vars, $this->vars) as $key => $val)
            $$key = $val;
        require $render_context_dir . $render_context_name . '.php';
    }

    public function render(string $view) {
        $this->renderByPath('templates/', $this->template, ['view' => $view]);
    }

    private function renderView(string $render_context_view) {
        $this->renderByPath('views/', $render_context_view, []);
    }
}
