<?php namespace PWC\Singleton;

use PWC\Singleton;

class Config extends Singleton
{
    protected $isSingleValue = false;
    protected $value = null;

    public static function get($name = null)
    {
        if (self::instance()->isSingleValue) {
            return self::instance()->value;
        } else {
            return self::instance()->$name;
        }
    }

    public static function set($name = null, $value = null)
    {
        if (self::instance()->isSingleValue) {
            self::instance()->value = $name;
        } else {
            self::instance()->$name = $value;
        }
    }

    public static function add($name = null, $value = null, $first = false)
    {
        if (self::instance()->isSingleValue) {
            self::instance()->value = $name;
        } else {
            if (is_array(self::instance()->$name)) {
                $exists = false;
                array_walk(self::instance()->$name, function ($a) use (&$exists, $value) {
                    if ($value == $a) {
                        $exists = true;
                    }
                });
                if (!$exists) {
                    if ($first) {
                        self::instance()->set($name, array_merge([$value], self::instance()->$name));
                    } else {
                        self::instance()->set($name, array_merge(self::instance()->$name, [$value]));
                    }
                }
            } elseif (is_string(self::instance()->$name)) {

            } elseif (is_numeric(self::instance()->$name)) {

            }
        }
    }

    public static function init($values = [])
    {
        if (self::instance()->isSingleValue) {
            self::instance()->value = $values;
        } else {
            foreach ($values as $name => $value) {
                self::instance()->set($name, $value);
            }
        }
    }
}
