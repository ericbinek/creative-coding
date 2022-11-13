<?php

namespace CreativeCoding\Image;

use \Exception;

class Image
{
    function __construct()
    {
        $this->name = null;
        $this->canvas = null;
        $this->handle = null;
    }

    function __set($name, $value)
    {
        switch ($name) {
            case 'name':
                $this->name = $value;
                break;
            case 'canvas':
                $this->canvas = $value;
                break;
            case 'handle':
                $this->handle = $value;
                break;

            default:
                throw new Exception(__METHOD__ . '(' . $name . ') unsupported', 1);
                break;
        }
    }
    
    function color($red, $green, $blue)
    {
        return imagecolorallocate(
            $this->handle,
            $red,
            $green,
            $blue
        );
    }
    
    function create()
    {
        $this->handle = imagecreate($this->canvas->width, $this->canvas->height);
        imageantialias($this->handle, true);
        imageresolution($this->handle, 144, 144);
    }
    
    function tick()
    {
        $this->canvas->tick($this->handle);
    }

    function save($file)
    {
        $this->canvas->render($this->handle);

        imagepng($this->handle, $file);
    }

    function stream()
    {
        ob_start();

        $this->canvas->render($this->handle);
        imagepng($this->handle);

        return ob_get_clean();
    }
    
    function destroy()
    {
        imagedestroy($this->handle);
    }
}
