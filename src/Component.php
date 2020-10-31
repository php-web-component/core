<?php namespace PWC;

use PWC\Component\Config;

class Component extends Core {
    protected $children = [];

    protected $config = [];

    public function __construct(...$children)
    {
        $this->children = $children;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function render()
    {
        return implode('', array_map(function($component) {
            return is_a($component, Component::class) ? $component->render() : (is_a($component, Config::class) ? '' : $component);
        }, $this->children));
    }

    use ComponentTrait;
}
