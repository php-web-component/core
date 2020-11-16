<?php namespace PWC;

class Config
{
    public static function of($class = '')
    {
        return $class::instance();
    }

    public static function register($class = '', $value = [])
    {
        $class::instance()->init($value);
    }
}
