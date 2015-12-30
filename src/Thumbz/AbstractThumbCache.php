<?php

namespace Thumbz;

use Imagine\Image\ImageInterface;

abstract class AbstractThumbCache
{


    /**
     * @param $params
     * @return bool
     * @throws Exception
     */
    abstract public function cacheExists($name, $width, $height, $format);

    abstract public function setCache($name, $width, $height, $format, ImageInterface $data);

    abstract public function getCache($name, $width, $height, $format);

    abstract public function flushAll();


    /**
     * The full path to the cached file
     */
    abstract public function getCachePath($name, $width, $height, $format);


    public function getCacheName($name, $width, $height, $format)
    {
        $path = $name . "." . $width . "-" . $height . "." . $format;
        return $path;
    }
}
