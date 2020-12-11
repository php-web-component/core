<?php namespace PWC;

use Exception;

class Singleton {
    private static $instances = [];

    protected function __construct()
    {}

    protected function __clone()
    {}

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }

    public static function instance()
    {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();

            if (method_exists(self::$instances[$class], 'setDefaultValue')) {
                self::$instances[$class]->setDefaultValue();
            }
        }

        return self::$instances[$class];
    }
}
