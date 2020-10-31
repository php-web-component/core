<?php namespace PWC;

use PWC\Component\Config;

class Component {
    protected $_parent = null;
    protected $_children = [];

    public function __construct(...$children)
    {
        $this->_children = $children;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function render()
    {
        return implode('', array_map(function($component) {
            return is_a($component, Component::class) ? $component->render() : (is_a($component, Config::class) ? '' : $component);
        }, $this->_children));
    }

    use BuilderTrait, ComponentTrait;
}
