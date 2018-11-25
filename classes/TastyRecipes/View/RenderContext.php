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
        string $ctx_dir,
        string $ctx_name,
        array $ctx_extra_vars = array())
    {
        $ctx = $this;
        foreach (array_merge($ctx_extra_vars, $this->vars) as $key => $val)
            $$key = $val;
        require $ctx_dir . $ctx_name . '.php';
    }

    public function render(string $view) {
        $this->renderPath('templates/', $this->template, ['ctx_view' => $view]);
    }

    public function renderView(string $view) {
        $this->renderPath('views/', $view);
    }

    public function renderFragment(string $fragment, array $extra_vars = array()) {
        $this->renderPath('fragments/', $fragment, $extra_vars);
    }
}
