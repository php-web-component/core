<?php namespace PWC\Component;

trait ComponentTrait
{
    public function config($config)
    {
        if (!is_null($config)) {
            if (is_array($config)) {
                foreach ($config as $name => $value) {
                    if (property_exists($this, $name)) {
                        $this->{$name} = $value;
                    }
                }
            }
        }

        return $this;
    }
}
