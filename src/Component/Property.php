<?php namespace PWC\Component;

use PWC\Component\Property\BuilderTrait;

class Property
{
    use BuilderTrait;

    protected $_value = null;

    public function __construct($value = null)
    {
        $this->_value = $value;
    }

    public function set($value = null)
    {
        $this->_value = $value;
        return $this;
    }

    public function get()
    {
        return $this->_value;
    }
}
