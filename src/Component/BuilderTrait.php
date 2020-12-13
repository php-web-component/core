<?php namespace PWC\Component;

trait BuilderTrait
{
    public static function build(array $params)
    {
        return new self($params);
    }
}
