<?php

namespace CreativeCoding\Image\Canvas;

use \Exception;

class Square
{
    function __construct()
    {
        $this->width = null;
        $this->height = null;
        $this->color = null;
        $this->grid = null;
    }

    function __set($name, $value)
    {
        switch ($name) {
            case 'width':
                $this->width = (int)$value;
                break;
            case 'height':
                $this->height = (int)$value;
                break;
            case 'color':
                $this->color = $value;
                break;
            case 'grid':
                $this->grid = $value;
                break;
            default:
                throw new Exception(__METHOD__ . '(' . $name . ') unsupported', 1);
                break;
        }
    }

    function tick($image)
    {
        $this->grid->tick($image, $this->width, $this->height);
    }

    function render($image)
    {
        imagefill($image, 0, 0, $this->color);

        $this->grid->render($image, $this->width, $this->height);
    }
}
