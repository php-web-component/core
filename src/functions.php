<?php

namespace PhpWebComponent;

use PhpWebComponent\Component\Text;

/**
 * Component from class string.
 *
 * @template TComponent of \PhpWebComponent\Component
 *
 * @param class-string<TComponent> $classString
 *
 * @return TComponent
 */
function component($classString)
{
    return new $classString();
}

/**
 * Property from class String.
 *
 * @template TProperty of \PhpWebComponent\Component\Property
 *
 * @param class-string<TProperty> $classString
 *
 * @return TProperty
 */
function property($classString)
{
    return new $classString();
}

/**
 * Text Component.
 */
function text(...$values): Text
{
    return component(Text::class)->set(...$values);
}
