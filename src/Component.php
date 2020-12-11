<?php namespace PWC;

use PWC\Component\BuilderTrait;
use PWC\Component\ComponentTrait;
use PWC\Component\Decorator;
use PWC\Component\Decorator\Collection as DecoratorCollection;

class Component
{
    protected $parent = null;
    protected $children = [];
    protected DecoratorCollection $decoratorCollection;

    public function __construct(...$params)
    {
        $this->initRef();
        $this->initProperties();

        $children = [];
        $decorators = [];
        foreach ($params as $param) {
            if (is_a($param, Decorator::class)) {
                $decorators[] = $param;
            } else {
                $found = false;
                if (is_object($param)) {
                    foreach ($this->getRef()->getProperties() as $prop) {
                        if (!is_null($prop->getType())) {
                            if (!$prop->getType()->isBuiltin()) {
                                if (is_subclass_of($prop->getType()->getName(), Collection::class)) {
                                    $paramType = $this->{$prop->getName()}::$_type;
                                } else {
                                    $paramType = $prop->getType()->getName();
                                }

                                if (get_class($param) == $paramType) {
                                    if (is_subclass_of($prop->getType()->getName(), Collection::class)) {
                                        $this->{$prop->getName()}->push($param);
                                    } else {
                                        $this->{$prop->getName()} = $param;
                                    }
                                    $found = true;

                                    break;
                                }
                            }
                        }
                    }
                }

                if (!$found) {
                    if (!is_null($param)) {
                        $children[] = $param;
                    }
                }
            }
        }

        $this->children = $children;
        $this->decoratorCollection->set(array_merge($this->decoratorCollection->get(), $decorators));

        $this->init();
    }

    protected function init()
    {}

    protected function setParent(Component $component)
    {
        $this->parent = $component;
        return $this;
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
                return (string) $component->setParent($this)->__mergeChildAndDecorator();
            } elseif (is_callable($component)) {
                return (string) $component();
            } else {
                return (string) $component;
            }
        }, $this->children));
    }

    protected function __mergeChildAndDecorator()
    {
        $this->children = array_merge($this->decoratorCollection->get(), $this->children);
        return $this;
    }

    public function withDecorator(?DecoratorCollection $collection)
    {
        if (!is_null($collection)) {
            $decorator = $collection->find(get_class($this));
            if (!is_null($decorator)) {
                $component = $decorator->getComponent();
                if ($decorator->isReplacement()) {
                    return $component;
                } else {
                    $this->_decorate($component);
                }
            }
        }

        return $this;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function asDecorator()
    {
        return new Decorator($this);
    }

    protected function _decorate($component)
    {
        $this->children = array_merge($this->children, $component->getChildren());
    }

    use BuilderTrait, ComponentTrait, ReflectionTrait;
}
