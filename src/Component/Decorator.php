<?php namespace PWC\Component;

use PWC\Component;

class Decorator
{
    protected Component $component;
    protected bool $isReplacement = false;

    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    public function setComponent(Component $component)
    {
        $this->component = $component;
        return $this;
    }

    public function getComponent()
    {
        return $this->component;
    }

    public function replace()
    {
        $this->isReplacement = true;
        return $this;
    }

    public function isReplacement()
    {
        return $this->isReplacement;
    }

    public function __toString()
    {
        return '';
    }

    public function decorate() : Component
    {
        return $this->component;
    }
}
