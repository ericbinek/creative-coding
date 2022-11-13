<?php

set_time_limit(0);

require './vendor/autoload.php';

use CreativeCoding\Image\Image as Image;
use CreativeCoding\Image\Canvas\Rectangle as Canvas;
use CreativeCoding\Image\Collection as Collection;
// use CreativeCoding\Image\Grid\Square as Grid;
use CreativeCoding\Image\Motive\Line as Motive;

function create($name, $thickness, $size, $dimensions, $colors, $framesPerSecond, $duration)
{
    list($width, $height) = $dimensions;
    list($fill, $stroke) = $colors;

    // Line
    $motive = new Motive();
    $motive->thickness = $thickness;

    // Tile
    // $motive = new Motive();
    // $motive->size = $size;
    // $motive->thickness = 1;
    // $motive->padding = 0;

    // $grid = new Grid();
    // $grid->columns = $columns;
    // $grid->rows = $rows;
    // $grid->motive = $motive;

    $collection = new Collection();
    $collection->motive = $motive;

    $canvas = new Canvas();
    $canvas->width = $width;
    $canvas->height = $height;

    $image = new Image();
    $image->name = $name;
    $image->canvas = $canvas;

    $image->create();

    $canvas->color = $image->color($fill[0], $fill[1], $fill[2]);
    $motive->color = $image->color($stroke[0], $stroke[1], $stroke[2]);

    $collection->create($size, 0, $width, 0, $height);

    $canvas->collection = $collection;

    $image->tick();

    $image->save('./' . $image->name . '.png');

    /**/
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
        . " -y " . $image->name . "__" . $framesPerSecond . "-" . $duration . "__white__" . $canvas->width . "x" . $canvas->height . ".mp4";

    $video = proc_open($command, $descriptors, $pipes);

    if (is_resource($video)) {
        for ($second = 0; $second < $duration; $second++) {

            // $image->save('./' . $image->name . '__' . $second . '.png');

            for ($frame = 0; $frame < $framesPerSecond; $frame++) {

                $image->tick();
                $image->tick();

                fwrite($pipes[0], $image->stream());
            }
        }
        $image->destroy();
        fclose($pipes[0]);
    }
    /**/
}

// Line
// create('dailyart', 2, 64, [512, 512], [[255, 255, 255], [0, 0, 0]], 24, 15);

// square
// create('dailyart', 16, 32, 32, [512, 512], [[255, 255, 255], [0, 0, 0]], 24, 15);

create('twitter-shared-image', 2, 64, [900, 450], [[255, 255, 255], [0, 0, 0]], 24, 15);
create('instagram-photo', 2, 64, [1080, 1080],  [[255, 255, 255], [0, 0, 0]], 24, 15);
create('instagram-story', 2, 64, [1080, 1920],  [[255, 255, 255], [0, 0, 0]], 24, 15);
create('tiktok', 2, 64, [1080, 1920],  [[255, 255, 255], [0, 0, 0]], 24, 15);
create('youtube-shorts', 2, 64, [1080, 1920],  [[255, 255, 255], [0, 0, 0]], 24, 15);

echo ceil(memory_get_usage() / 1024) . " kBytes \n";
