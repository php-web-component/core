<?php

namespace PhpWebComponent\Component\Feature;

use PhpWebComponent\Component\Property;
use SebastianBergmann\Type\Type;

trait AutoSetter
{
    use SelfReflection;

    protected function _autoSetPropertyFromValue(Property $value)
    {
        foreach ($this->_selfReflection->getProperties() as $property) {
            if ($property->getType()->getName() === Type::fromValue($value, false)->name()) {
                $this->{$property->getName()} = $value;
                break;
            }
        }
    }
}
