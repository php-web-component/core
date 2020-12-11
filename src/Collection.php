<?php namespace PWC;

class Collection
{
    public static $type = null;
    protected array $values = [];

    public function get(): array
    {
        return $this->values;
    }

    public function set(array $values = [])
    {
        if (is_array($values)) {
            $this->values = $values;
        }

        return $this;
    }

    public function push($value = null)
    {
        if (!is_null(static::$type)) {
            if (is_object($value)) {
                if (get_class($value) == static::$type) {
                    $this->values[] = $value;
                }
            }
        }
    }

    public function find($type = null, $keep = false)
    {
        $class = null;
        $num = null;
        foreach ($this->values as $key => $value) {
            if (get_class($value->getComponent()) == $type) {
                $class = $value;
                $num = $key;
                break;
            }
        }

        if (!$keep) {
            if (!is_null($num)) {
                unset($this->values[$num]);
            }
        }

        return $class;
    }
}
