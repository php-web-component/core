<?php namespace PWC;

use ReflectionClass;

trait ReflectionTrait
{
    protected $_ref = null;

    protected function _initRef()
    {
        $this->_ref = new ReflectionClass($this);
    }

    protected function _getRef()
    {
        return $this->_ref ?? new ReflectionClass($this);
    }

    protected function _initProperties()
    {
        foreach ($this->_ref->getProperties() as $prop) {
            $access = false;
            if ($prop->isProtected() || $prop->isPrivate()) {
                $access = true;
                $prop->setAccessible($access);
            }

            if (!is_null($prop->getType())) {
                if (!$prop->getType()->isBuiltin()) {
                    if (!$prop->isInitialized($this)) {
                        if (!$prop->getType()->allowsNull()) {
                            $class = $prop->getType()->getName();
                            $this->{$prop->getName()} = new $class();
                        } else {
                            $this->{$prop->getName()} = null;
                        }
                    }
                }
            }

            if ($access) {
                $prop->setAccessible(false);
            }
        }
    }
}
