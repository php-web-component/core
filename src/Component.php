<?php

namespace PhpWebComponent;

use PhpWebComponent\Component\Feature\{AutoInitializer, AutoSetter, HasContent, HasParent, SelfReflection, StaticCreate};

abstract class Component
{
    use SelfReflection;
    use AutoInitializer;
    use AutoSetter;
    use StaticCreate;
    use HasParent;
    use HasContent;

    public function __construct()
    {
        $this->_selfReflect();
        $this->_autoInitializeProperties();

        $this->_init();
    }

    protected function _init() {}

    public function set(...$values): static
    {
        foreach ($values as $value) {
            $this->addContent($value);
        }

        return $this;
    }
}
