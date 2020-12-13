<?php namespace PWC\Component;

use PWC\Component;
use PWC\Component\Text\Separator;

class Text extends Component
{
    use BuilderTrait;

    public ?Separator $_separator;

    public function render(): string
    {
        $separator = '';
        if (!is_null($this->_separator)) {
            $separator = $this->_separator->get() ?? '';
        }

        return implode($separator, array_map(function($child) {
            if (is_object($child)) {
                if (method_exists($child, '__toString')) {
                    return (string) $child;
                }
            } else {
                if (!is_array($child)) {
                    return (string) $child;
                }
            }
        }, $this->_children));
    }
}
