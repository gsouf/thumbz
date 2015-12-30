<?php
/**
 * @license see LICENSE
 */

namespace Thumbz;


use Imagine\Image\BoxInterface;
use Imagine\Image\Palette\Color\ColorInterface;
use Imagine\Imagick\Imagine;

abstract class Image
{

    public static function open($file){
        $adapter = new Imagine();
        return $adapter->open($file);
    }

    public static function create(BoxInterface $size, ColorInterface $color = null){
        $adapter = new Imagine();
        return $adapter->create($size, $color);
    }

    public static function load($string){
        $adapter = new Imagine();
        return $adapter->load($string);
    }

    public static function read($resource){
        $adapter = new Imagine();
        return $adapter->load($resource);
    }



}