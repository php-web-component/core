<?php namespace PWC;

use PWC\Component\BuilderTrait;
use PWC\Component\Property;

class Component
{
    use ReflectionTrait, BuilderTrait;

    protected $_children = [];

    public function __construct($params = null)
    {
        $this->_initRef();
        $this->_initProperties();

        if (!is_null($params)) {
            $params = is_array($params) ? $params : [$params];
            $children = [];
            foreach ($params as $component => $values) {
                $prop = null;
                if (is_subclass_of($component, Component::class)) {
                    if (is_callable($values)) {
                        $values = $values();
                    }
    
                    if (!is_array($values)) {
                        $values = [$values];
                    }

                    $child = $component::build($values);
                } elseif (is_subclass_of($component, Property::class)) {
                    $child = $component::build($values);
                } elseif (is_object($values) && is_a($values, Component::class)) {
                    $prop = $component;
                    $child = $values;
                }  elseif (is_object($values) && is_a($values, Property::class)) {
                    $prop = $component;
                    $child = $values;
                } elseif (!is_object($values) && is_subclass_of($values, Component::class)) {
                    $prop = $component;
                    $child = $values::build();
                } elseif (!is_object($values) && is_subclass_of($values, Property::class)) {
                    $prop = $component;
                    $child = $values::build();
                } else {
                    $prop = $component;
                    $child = $values;
                }
    
                if (is_object($child)) {
                    if (!$this->_checkComponentProperty($child, $prop)) {
                        $children[] = $child;
                    }
                } else {
                    if (!is_null($prop)) {
                        if (property_exists($this, $prop)) {
                            $this->{$prop} = $child;
                        } else {
                            $children[$prop] = $child;
                        }
                    } else {
                        $children[] = $child;
                    }
                }
            }

            $this->_children = $children;
        }

        $this->_init();
    }

    protected function _init()
    {}

    protected function _checkComponentProperty($component, $prop = null)
    {
        $found = false;

        if (!is_null($prop)) {
            if (property_exists($this, $prop)) {
                $this->{$prop} = $component;
                return true;
            }
        }

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
