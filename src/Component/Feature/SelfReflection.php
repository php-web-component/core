<?php

namespace PhpWebComponent\Component\Feature;

use ReflectionClass;

trait SelfReflection
{
    /**
     * Class self reflection
     *
     * @var ReflectionClass
     */
    protected ReflectionClass $_selfReflection;

    protected function _selfReflect()
    {
        $this->_selfReflection = new ReflectionClass($this);
    }
}
