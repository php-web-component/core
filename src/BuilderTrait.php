<?php namespace PWC;

trait BuilderTrait {
    public static function build(...$params)
    {
        return new self(...$params);
    }
}
