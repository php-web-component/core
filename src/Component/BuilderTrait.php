<?php namespace PWC\Component;

trait BuilderTrait
{
    public static function build(...$params)
    {
        return new self(...$params);
    }
}
