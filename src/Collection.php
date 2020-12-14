<?php namespace PWC;

class Collection
{
    public static $type = null;
    public static $includeSubClass = false;
    protected array $_values = [];

    public function get(): array
    {
        return $this->_values;
    }

    public function set(array $values = [])
    {
        if (is_array($values)) {
            $this->_values = $values;
        }

        return $this;
    }

    public function push($value = null)
    {
        if (!is_null(static::$type)) {
            if (is_object($value)) {
                if (get_class($value) == static::$type || (static::$includeSubClass && is_subclass_of(get_class($value), static::$type))) {
                    $this->_values[] = $value;
                }
            }
        }
    }

    public function pull($object)
    {
        $class = null;
        $num = null;

        $type = is_object($object) ? get_class($object) : $object;

        foreach ($this->_values as $key => $value) {
            if (get_class($value) == $type) {
                $num = $key;
                $class = $value;
                break;
            }
        }

        if (!is_null($num)) {
            unset($this->_values[$num]);
            $this->_values = array_values($this->_values);
        }

        return $class;
    }
}
