<?php

namespace PhpWebComponent\Component\Feature;

use PhpWebComponent\Component;
use PhpWebComponent\Component\Property;

trait HasContent
{
    use HasParent;
    use AutoSetter;

    protected array $_content = [];

    public function addContent(mixed $content = null): static
    {
        if ($content instanceof Property) {
            $this->_autoSetPropertyFromValue($content);
        } else {
            if ($content instanceof Component) {
                $content->setParent($this);
            }

            $this->_content[] = $content;
        }

        return $this;
    }
}
