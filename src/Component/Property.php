<?php namespace PWC\Component;

class Property
{
    protected $value = null;

    public function __construct($value = null)
    {
        $this->value =  $value;
    }

    public function setValue($value = null)
    {
        $this->value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }
}
