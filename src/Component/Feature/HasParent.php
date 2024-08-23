<?php

namespace PhpWebComponent\Component\Feature;

use PhpWebComponent\Component;

trait HasParent
{
    protected ?Component $_parent = null;

    public function setParent(Component $parent): static
    {
        $this->_parent = $parent;

        return $this;
    }
}
