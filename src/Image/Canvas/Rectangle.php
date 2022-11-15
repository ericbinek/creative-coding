<?php

namespace CreativeCoding\Image\Canvas;

use \Exception;

class Rectangle
{
    function __construct()
    {
        $this->width = null;
        $this->height = null;
        $this->color = null;
        $this->collection = null;
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
            case 'collection':
                $this->collection = $value;
                break;
            default:
                throw new Exception(__METHOD__ . '(' . $name . ') unsupported', 1);
                break;
        }
    }

    function tick($image)
    {
        imagefilledrectangle($image, 0, 0, $this->width, $this->height, $this->color);

        $this->collection->tick($image, $this->width, $this->height);
    }

    function render($image)
    {
        imagefill($image, 0, 0, $this->color);

        $this->collection->render($image);
    }
}
