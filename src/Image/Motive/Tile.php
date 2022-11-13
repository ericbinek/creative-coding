<?php

namespace CreativeCoding\Image\Motive;

use \Exception;

class Tile
{
    function __construct()
    {
        $this->size = null;
        $this->color = null;
        $this->background = null;
        $this->padding = null;
        $this->thickness = null;
        $this->shots = [];
    }

    function __set($name, $value)
    {
        switch ($name) {
            case 'size':
                $this->size = (int)$value;
                break;
            case 'color':
                $this->color = $value;
                break;
            case 'background':
                $this->background = $value;
                break;
            case 'shots':
                $this->shots = $value;
                break;
            case 'padding':
                $this->padding = (int)$value;
                break;
            case 'thickness':
                $this->thickness = (int)$value;
                break;
            default:
                throw new Exception(__METHOD__ . '(' . $name . ') unsupported', 1);
                break;
        }
    }


    function tick($image, $offsetX, $offsetY)
    {
        if (rand(0, 1) === 1) {
            $this->thickness++;
        } else {
            $this->thickness--;
        }
    }

    function render($image, $offsetX, $offsetY)
    {
        for ($i = 0; $i < $this->thickness; $i++) {

            $fromX = $offsetX + $this->padding + $i; // from X
            $fromY = $offsetY + $this->padding + $i; // from Y
            $toX = $offsetX + $this->size - ($this->padding + 1) - $i; // to X
            $toY = $offsetY + $this->size - ($this->padding + 1) - $i; // to Y

            imagerectangle(
                $image,
                $fromX,
                $fromY,
                $toX,
                $toY,
                $this->color
            );
        }
    }
}
