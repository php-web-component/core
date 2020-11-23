<?php namespace PWC;

class Component {
    protected $_ID = 'pwc-component';
    protected $_parent = null;
    protected $_children = [];

    public function __construct(...$children)
    {
        $this->_children = $children;
    }

    protected function _setParent(Component $component)
    {
        $this->_parent = $component;
    }

    public function __toString()
    {
        return $this->render();
    }

    /**
     * Render component
     *
     * @return string
     */
    public function render(): string
    {
        return implode('', array_map(function($component) {
            if (is_a($component, Component::class)) {
                $component->_setParent($this);
            }

            return (string) (is_callable($component) ? $component() : $component);
        }, $this->_children));
    }

    public function decorate($config = [])
    {
        foreach ($config as $name => $value) {
            $this->$name($value);
        }

        return $this;
    }

    use BuilderTrait, ComponentTrait;
}
