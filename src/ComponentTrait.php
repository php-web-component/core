<?php namespace PWC;

trait ComponentTrait {
    public function config(array $config = [])
    {
        foreach ($config as $name => $value) {
            if (property_exists(self::class, $name)) {
                $this->{$name} = $value;
            }
        }

        return $this;
    }
}
