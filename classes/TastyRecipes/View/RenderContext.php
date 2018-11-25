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

    public function renderPath(
        string $render_context_dir,
        string $render_context_name,
        array $render_context_extra_vars = array())
    {
        $ctx = $this;
        foreach (array_merge($render_context_extra_vars, $this->vars) as $key => $val)
            $$key = $val;
        require $render_context_dir . $render_context_name . '.php';
    }

    public function render(string $view) {
        $this->renderPath('templates/', $this->template, ['view' => $view]);
    }

    public function renderView(string $view) {
        $this->renderPath('views/', $view);
    }

    public function renderFragment(string $fragment, array $extra_vars = array()) {
        $this->renderPath('fragments/', $fragment, $extra_vars);
    }
}
