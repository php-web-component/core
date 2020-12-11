<?php namespace PWC\Component;

use PWC\Component;
use PWC\Component\Text\Separator;

class Text extends Component
{
    protected ?Separator $separator;

    public function render(): string
    {
        $separator = '';
        if (!is_null($this->separator)) {
            $separator = $this->separator->getValue() ?? '';
        }

        return (string) implode($separator, array_map(function ($value) {
            if (is_bool($value) || is_string($value) || is_int($value) || is_float($value)) {
                return (string) $value;
            }
        }, $this->children));
    }

    use BuilderTrait;
}
