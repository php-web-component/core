<?php namespace PWC;

use ReflectionClass;

trait ReflectionTrait
{
    protected $ref = null;

    protected function initRef()
    {
        $this->ref = new ReflectionClass($this);
    }

    protected function getRef()
    {
        return $this->ref ?? new ReflectionClass($this);
    }

    protected function initProperties()
    {
        foreach ($this->ref->getProperties() as $prop) {
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
