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
    abstract public function cacheExists(ThumbCacheItem $cacheItem);

    abstract public function setCache(ThumbCacheItem $cacheItem, ImageInterface $data);

    abstract public function getCache(ThumbCacheItem $cacheItem);

    abstract public function flushAll();

    /**
     * Generate a cache item to ease the work with the cache
     */
    public function getItem($name, $width, $height, $format)
    {
        $name = $name . "." . $width . "-" . $height . "." . $format;
        return new ThumbCacheItem($name, $format, $this);
    }

    /**
     * The full path to the cached file
     */
    abstract public function getCachePath(ThumbCacheItem $cacheItem);

}
