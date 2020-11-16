<?php namespace PWC\Singleton;

class Config extends \PWC\Singleton
{
    protected $_isSingleValue = false;
    protected $value = null;

    public function get($name = null)
    {
        if ($this->_isSingleValue) {
            return $this->value;
        } else {
            return $this->$name;
        }
    }

    public function set($name = null, $value = null)
    {
        if ($this->_isSingleValue) {
            $this->value = $name;
        } else {
            $this->$name = $value;
        }
    }

    public function init($values = [])
    {
        if ($this->_isSingleValue) {
            $this->value = $values;
        } else {
            foreach ($values as $name => $value) {
                $this->set($name, $value);
            }
        }
    }
}
