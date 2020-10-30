<?php namespace PWC;

class Component extends Core {
    protected $children = [];

    public function __construct(...$params)
    {
        if (is_array($params)) {
            foreach ($params as $param) {
                if (is_a($param, Component::class)) {
                    $this->children[] = $param;
                }
            }
        }
    }

    public function render()
    {
        $result = '';

        foreach ($this->children as $component) {
            $result .= $component->render();
        }

        return $result;
    }
}
