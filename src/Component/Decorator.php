<?php namespace PWC\Component;

use PWC\Component;

class Decorator
{
    protected Component $_component;
    protected bool $_isReplacement = false;

    public function __construct(Component $component)
    {
        $this->_component = $component;
    }

    public function setComponent(Component $component)
    {
        $this->_component = $component;
        return $this;
    }

    public function getComponent()
    {
        return $this->_component;
    }

    public function replace()
    {
        $this->_isReplacement = true;
        return $this;
    }

    public function isReplacement()
    {
        return $this->_isReplacement;
    }

    public function __toString()
    {
        return '';
    }
}
