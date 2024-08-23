<?php

namespace PhpWebComponent\Component;

abstract class Property
{
    /**
     * Property's value
     *
     * @var mixed
     */
    protected mixed $_value = null;

    public function __construct() {}

    public function set(mixed $value = null): static
    {
        $this->_value = $value;

        return $this;
    }

    public function get(): mixed
    {
        $value = $this->_value;

        while ($value instanceof Property) {
            $value = $value->get();
        }

        return $value;
    }
}
