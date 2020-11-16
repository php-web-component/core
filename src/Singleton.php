<?php namespace PWC;

class Singleton {
    private static $__instances = [];

    protected function __construct()
    {}

    protected function __clone()
    {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }

    public static function instance()
    {
        $class = static::class;
        if (!isset(self::$__instances[$class])) {
            self::$__instances[$class] = new static();

            if (method_exists(self::$__instances[$class], '__setDefaultValue')) {
                self::$__instances[$class]->__setDefaultValue();
            }
        }

        return self::$__instances[$class];
    }
}
