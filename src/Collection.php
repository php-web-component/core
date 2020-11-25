<?php namespace PWC;

class Collection
{
    public static $_type = null;
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
        if (!is_null(static::$_type)) {
            if (is_object($value)) {
                if (get_class($value) == static::$_type) {
                    $this->_values[] = $value;
                }
            }
        }
    }

    public function find($type = null, $keep = false)
    {
        $class = null;
        $num = null;
        foreach ($this->_values as $key => $value) {
            if (get_class($value->getComponent()) == $type) {
                $class = $value;
                $num = $key;
                break;
            }
        }

        if (!$keep) {
            if (!is_null($num)) {
                unset($this->_values[$num]);
            }
        }

        return $class;
    }
}
