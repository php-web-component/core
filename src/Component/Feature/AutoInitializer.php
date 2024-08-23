<?php

namespace PhpWebComponent\Component\Feature;

use SebastianBergmann\Type\Type;

trait AutoInitializer
{
    use SelfReflection;

    protected function _autoInitializeProperties()
    {
        foreach ($this->_selfReflection->getProperties() as $property) {
            if (!$property->isInitialized($this)) {
                $allowNull = $property->getType()->allowsNull();
                $propertyName = $property->getName();
                $propertyType = Type::fromName($property->getType()->getName(), $allowNull);

                if ($allowNull) {
                    $this->{$propertyName} = null;
                } else {
                    if ($propertyType->isObject()) {
                        $propertyObjectClassName = $propertyType->asString();
                        $this->{$propertyName} = new $propertyObjectClassName();
                    } else {
                        $this->{$propertyName} = match (strtolower($propertyType->asString())) {
                            'callable' => function () {},
                            'true' => true,
                            'false' => false,
                            'null' => null,
                            'array' => [],
                            'bool' => false,
                            'boolean' => false,
                            'double' => 0.0,
                            'float' => 0.0,
                            'int' => 0,
                            'integer' => 0,
                            'real' => 0,
                            'string' => '',
                            'mixed' => null,
                        };
                    }
                }
            }
        }
    }
}
