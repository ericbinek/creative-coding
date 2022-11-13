<?php

namespace CreativeCoding\Image\Grid;

use \Exception;

class Square
{
    function __construct()
    {
        $this->columns = null;
        $this->rows = null;
        $this->motive = null;
        $this->grid = [];
    }

    function __set($name, $value)
    {
        switch ($name) {
            case 'columns':
                $this->columns = (int)$value;
                break;
            case 'rows':
                $this->rows = (int)$value;
                break;
            case 'motive':
                $this->motive = $value;
                break;
            case 'grid':
                $this->grid = $value;
                break;

            default:
                throw new Exception(__METHOD__ . '(' . $name . ') unsupported', 1);
                break;
        }
    }

    function create($width, $height, $size)
    {
        // fix oversize
        if (($this->columns * $size) > $width) {
            $this->columns = floor($width / $size);
        }
        // fix oversize
        if (($this->rows * $this->motive->size) > $height) {
            $this->rows = floor($height / $size);
        }

        $startX = floor(($width - ($this->columns * $this->motive->size)) / 2);
        $startY = floor(($height - ($this->rows * $this->motive->size)) / 2);

        // create grid
        for ($x = 0; $x < $this->columns; $x++) {
            $this->grid[$x] = [];
            for ($y = 0; $y < $this->rows; $y++) {
                $this->grid[$x][$y] = clone $this->motive;

                $this->grid[$x][$y]->x = $startX + ($x * $this->grid[$x][$y]->size);
                $this->grid[$x][$y]->y = $startY + ($y * $this->grid[$x][$y]->size);
            }
        }
    }

    function tick($image)
    {
        for ($x = 0; $x < $this->columns; $x++) {
            for ($y = 0; $y < $this->rows; $y++) {
                $this->grid[$x][$y]->tick($image);
            }
        }
    }

    function render($image, $width, $height)
    {
        for ($x = 0; $x < $this->columns; $x++) {
            for ($y = 0; $y < $this->rows; $y++) {
                $this->grid[$x][$y]->render($image);
            }
        }
    }
}
