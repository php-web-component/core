<?php namespace PWC\Singleton;

class Config extends \PWC\Singleton
{
    protected $_isSingleValue = false;
    protected $value = null;

    public function get($name = null)
    {
        if (self::instance()->_isSingleValue) {
            return self::instance()->value;
        } else {
            return self::instance()->$name;
        }
    }

    public function set($name = null, $value = null)
    {
        if (self::instance()->_isSingleValue) {
            self::instance()->value = $name;
        } else {
            self::instance()->$name = $value;
        }
    }

    public static function init($values = [])
    {
        if (self::instance()->_isSingleValue) {
            self::instance()->value = $values;
        } else {
            foreach ($values as $name => $value) {
                self::instance()->set($name, $value);
            }
        }
    }
}
