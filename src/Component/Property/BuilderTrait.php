<?php namespace PWC\Component\Property;

trait BuilderTrait
{
    public static function build($value = null)
    {
        return new self($value);
    }
}
