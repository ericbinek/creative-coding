<?php

namespace CreativeCoding\Image\Motive;

use \Exception;

class Line
{
    function __construct()
    {
        $this->from = null;
        $this->to = null;
        $this->size = null;
        $this->thickness = null;
        $this->color = null;
    }

    function __set($name, $value)
    {
        switch ($name) {
            case 'from':
                $this->from = $value;
                break;
            case 'to':
                $this->to = $value;
                break;
            case 'size':
                $this->size = (int)$value;
                break;
            case 'thickness':
                $this->thickness = (int)$value;
                break;
            case 'color':
                $this->color = $value;
                break;
            default:
                throw new Exception(__METHOD__ . '(' . $name . ') unsupported', 1);
                break;
        }
    }


    function tick($from = null, $to = null)
    {

    }

    function render($image)
    {
        imagesetthickness($image, $this->thickness);
        imageline(
            $image,
            $this->from[0],
            $this->from[1],
            $this->to[0],
            $this->to[1],
            $this->color
        );
    }
}
