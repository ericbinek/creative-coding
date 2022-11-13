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
            $this->relation[] = [
                rand($minWidth, $maxWidth),
                rand($minHeight, $maxHeight)
            ];
        }

        $relation = $this->relation;
        $start = array_shift($relation);
        $from = $start;
        $to = null;

        for ($n = 0; $n < $size; $n++) {
            $motive = clone $this->motive;
            $motive->from = $from;
            if (($n + 2) < $size) {
                $to = array_shift($relation);
            } else {
                $to = $start;
            }
            $motive->to = $to;
            $this->collection[] = $motive;
            $from = $to;
        }
    }

    function tick()
    {
        foreach ($this->relation as $i => $relation) {
            $this->relation[$i] = [
                rand(0, 1) == 1 ? ++$relation[0] : --$relation[0],
                rand(0, 1) == 1 ? ++$relation[1] : --$relation[1]
            ];
        }

        foreach ($this->collection as $i => $motive) {
            $motive->from = $this->relation[$i];
            if (isset($this->relation[$i + 1])) {
                $motive->to = $this->relation[$i + 1];
            } else {
                $motive->to = $this->relation[0];
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
