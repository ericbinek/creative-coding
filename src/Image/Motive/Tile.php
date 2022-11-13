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
        $this->x = null;
        $this->y = null;
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
            case 'x':
                $this->x = (int)$value;
                break;
            case 'y':
                $this->y = (int)$value;
                break;
            default:
                throw new Exception(__METHOD__ . '(' . $name . ') unsupported', 1);
                break;
        }
    }


    function tick()
    {
        if (rand(0, 1) === 1) {
            $this->thickness++;
        } else {
            $this->thickness--;
        }
    }

    function render($image)
    {
        for ($i = 0; $i < $this->thickness; $i++) {

            $fromX = $this->x + $this->padding + $i; // from X
            $fromY = $this->y + $this->padding + $i; // from Y
            $toX = $this->x + $this->size - ($this->padding + 1) - $i; // to X
            $toY = $this->y + $this->size - ($this->padding + 1) - $i; // to Y

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
