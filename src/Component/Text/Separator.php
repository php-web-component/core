<?php

namespace PhpWebComponent\Component\Text;

use PhpWebComponent\Component\Property;

/**
 * @method static set(string $value = ' ')
 * @method string get()
 */
class Separator extends Property
{
    public function __construct()
    {
        parent::__construct();

        $this->_value = ' ';
    }

    public function get(): mixed
    {
        $value = parent::get();

        if (!is_string($value)) {
            return ' ';
        }

        return $value;
    }
}
