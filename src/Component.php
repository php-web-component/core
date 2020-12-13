<?php namespace PWC;

use PWC\Component\BuilderTrait;

class Component
{
    use ReflectionTrait, BuilderTrait;

    protected $_children = [];

    public function __construct(array $params)
    {
        $this->_initRef();
        $this->_initProperties($params);

        $children = [];
        foreach ($params as $component => $values) {
            if (is_subclass_of($component, Component::class)) {
                if (is_callable($values)) {
                    $values = $values();
                }

                if (!is_array($values)) {
                    $values = [$values];
                }

                $x = $component::build($values);
            } elseif (is_object($values) && is_a($values, Component::class)) {
                $x = $values;
            } elseif (!is_object($values) && is_subclass_of($values, Component::class)) {
                $x = $values::build([]);
            } else {
                $x = $values;
            }

            if (is_object($x)) {
                if (!$this->_checkComponentProperty($x)) {
                    $children[] = $x;
                }
            } else {
                $children[] = $x;
            }
        }

        $this->_children = $children;

        $this->_init();
    }

    protected function _init()
    {}

    protected function _checkComponentProperty($component)
    {
        $found = false;
        foreach ($this->_getRef()->getProperties() as $prop) {
            if (!is_null($prop->getType())) {
                if (!$prop->getType()->isBuiltin()) {
                    $collection = false;
                    $includeSubClass = false;
                    if (is_subclass_of($prop->getType()->getName(), Collection::class)) {
                        $paramType = $this->{$prop->getName()}::$type;
                        $includeSubClass = $this->{$prop->getName()}::$includeSubClass;
                        $collection = true;
                    } else {
                        $paramType = $prop->getType()->getName();
                    }

                    if ((get_class($component) == $paramType || ($collection && is_subclass_of(get_class($component), $paramType) && $includeSubClass)) && $prop->isPublic()) {
                        if (is_subclass_of($prop->getType()->getName(), Collection::class)) {
                            $this->{$prop->getName()}->push($component);
                        } else {
                            $this->{$prop->getName()} = $component;
                        }
                        $found = true;

                        break;
                    }
                }
            }
        }

        return $found;
    }

    public function render(): string
    {
        return implode('', array_map(function ($component) {
            return (string) $component;
        }, $this->_children));
    }

    public function __toString()
    {
        return $this->render();
    }
}
