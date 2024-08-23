<?php

namespace PhpWebComponent\Component;

use PhpWebComponent\Component;
use PhpWebComponent\Component\Feature\Renderable as FeatureRenderable;
use PhpWebComponent\Component\Principle\Renderable;
use PhpWebComponent\Component\Text\Separator;

class Text extends Component implements Renderable
{
    use FeatureRenderable {
        __toString as __renderableToString;
    }

    protected Separator $_separator;

    public function __toString(): string
    {
        $this->_renderSeparator = $this->_separator->get();

        return $this->__renderableToString();
    }
}
