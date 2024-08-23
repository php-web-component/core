<?php

namespace PhpWebComponent\Component\Feature;

trait StaticCreate
{
    public static function create(): static
    {
        return new static();
    }
}
