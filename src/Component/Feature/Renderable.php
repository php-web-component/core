<?php

namespace PhpWebComponent\Component\Feature;

use PhpWebComponent\Component\Principle\Composable;

trait Renderable
{
    use HasContent;

    protected string $_renderSeparator = '';

    /**
     * @param string $separator
     * @param mixed ...$components
     * @return string
     */
    protected function _render(string $separator = '', ...$components): string
    {
        return implode($separator, array_map(function (mixed $item) use ($separator) {
            if (is_array($item)) {
                return $this->renderWithSeparator($separator, ...$item);
            } else {
                if (settype($item, 'string')) {
                    return strval($item);
                } else {
                    return '';
                }
            }
        }, $components));
    }

    public function __toString(): string
    {
        $content = $this->_content;

        if ($this->_selfReflection->implementsInterface(Composable::class)) {
            $content = $this->composition();
        }

        if (!is_array($content)) {
            $content = [$content];
        }

        return $this->_render($this->_renderSeparator, ...$content);
    }
}
