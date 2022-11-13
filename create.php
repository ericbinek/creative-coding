<?php

set_time_limit(0);

require './vendor/autoload.php';

use CreativeCoding\Image\Image as Image;
use CreativeCoding\Image\Canvas\Square as Canvas;
use CreativeCoding\Image\Grid\Square as Grid;
use CreativeCoding\Image\Motive\Tile as Motive;

function create($name, $size, $columns, $rows, $dimensions, $colors, $framesPerSecond, $duration)
{
    list($width, $height) = $dimensions;
    list($fill, $stroke) = $colors;

    $motive = new Motive();
    $motive->size = $size;
    $motive->thickness = 1;
    $motive->padding = 0;

    $grid = new Grid();
    $grid->columns = $columns;
    $grid->rows = $rows;
    $grid->motive = $motive;

    $canvas = new Canvas();
    $canvas->width = $width;
    $canvas->height = $height;
    $canvas->grid = $grid;

    $image = new Image();
    $image->canvas = $canvas;
    $image->name = $name;

    $image->create();

    $canvas->color = $image->color($fill[0], $fill[1], $fill[2]);
    $motive->color = $image->color($stroke[0], $stroke[1], $stroke[2]);

    $grid->create($canvas->width, $canvas->height, $motive->size);

    $descriptors = [
        ['pipe', '0']
    ];

    $command = "ffmpeg"
        . " -f image2pipe"
        . " -pix_fmt rgb24"
        . " -r " . $framesPerSecond
        . " -c:v png"
        . " -i - "
        . " -vcodec libx264"
        . " -pix_fmt yuv420p"
        . " -y " . $image->name . "__" . $framesPerSecond . "-" . $duration . "__" . $motive->size . "__white__" . $grid->columns . "x" . $grid->rows . "__" . $canvas->width . "x" . $canvas->height . ".mp4";

    $video = proc_open($command, $descriptors, $pipes);

    if (is_resource($video)) {
        for ($second = 0; $second < $duration; $second++) {

            // $image->save('./' . $image->name . '__' . $second . '.png');

            for ($frame = 0; $frame < $framesPerSecond; $frame++) {

                $image->tick();
                $image->tick();
                $image->tick();

                fwrite($pipes[0], $image->stream());
            }
        }
        $image->destroy();
        fclose($pipes[0]);
    }
}

create('dailyart', 16, 32, 32, [512, 512], [[255, 255, 255], [0, 0, 0]], 24, 15);

// create('twitter-shared-image', 32, 20, 10, [900, 450], [[255, 255, 255], [0, 0, 0]], 24, 15);
// create('instagram-photo', 32, 24, 24, [1080, 1080],  [[255, 255, 255], [0, 0, 0]], 24, 15);
// create('instagram-story', 32, 24, 48, [1080, 1920],  [[255, 255, 255], [0, 0, 0]], 24, 15);

echo ceil(memory_get_usage() / 1024) . " kBytes \n";
