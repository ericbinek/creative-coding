<?php

namespace CreativeCoding\Image;

use \Exception;

class Collection
{
    function __construct()
    {
        $this->motive = null;
        $this->collection = [];
        $this->relation = [];
    }

    function __set($name, $value)
    {
        switch ($name) {
            case 'motive':
                $this->motive = $value;
                break;
            case 'collection':
                $this->collection = $value;
                break;
            case 'relation':
                $this->relation = $value;
                break;

            default:
                throw new Exception(__METHOD__ . '(' . $name . ') unsupported', 1);
                break;
        }
    }

    function create($size, $minWidth, $maxWidth, $minHeight, $maxHeight)
    {

        for ($n = 0; $n < $size; $n++) {
            $motive = clone $this->motive;
            $motive->from = [$minWidth, $minHeight + ($n * 16)];
            $motive->to = [$maxWidth, $minHeight + ($n * 16)];
            $this->collection[] = $motive;
        }
    }

    function tick($image, $width, $height)
    {
        foreach ($this->collection as $i => $motive) {
            if (rand(0, 1)) {
                if (rand(0, 1)) {
                    $this->collection[$i]->from[0]++;
                } else {
                    $this->collection[$i]->from[0]--;
                }
            } else {
                if (rand(0, 1)) {
                    $this->collection[$i]->to[0]++;
                } else {
                    $this->collection[$i]->to[0]--;
                }
            }
        }
    }

    function render($image)
    {
        foreach ($this->collection as $motive) {
            $motive->render($image);
        }
    }
}
