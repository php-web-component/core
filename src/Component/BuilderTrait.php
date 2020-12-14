<?php namespace PWC\Component;

trait BuilderTrait
{
    public static function build($params = null)
    {
        return new self($params);
    }
}
