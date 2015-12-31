<?php
/**
 * @license see LICENSE
 */

namespace Thumbz;

class ThumbCacheItem
{

    protected $name;
    protected $width;
    protected $height;
    protected $format;

    /**
     * @var AbstractThumbCache
     */
    protected $thumbCache;

    /**
     * CacheItem constructor.
     * @param string $name name of the image
     * @param int $width width of the thumbnail
     * @param int $height height of the thumbnail
     * @param string $format format of the thumbnail (jpg, png, gif..)
     * @param AbstractThumbCache $cacheAdapter cache interface
     */
    public function __construct($name, $width, $height, $format, AbstractThumbCache $cacheAdapter)
    {
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;
        $this->format = $format;
        $this->thumbCache = $cacheAdapter;
    }

    /**
     * Check if a cache exists for the item
     * @return bool
     */
    public function cacheExists()
    {
        return $this->thumbCache->cacheExists($this->name, $this->width, $this->height, $this->format);
    }

    /**
     * Save the data
     * @param $data
     */
    public function setCache($data)
    {
        $this->thumbCache->setCache($this->name, $this->width, $this->height, $this->format, $data);
    }


    /**
     * Get the path to the cached file
     * @return mixed
     */
    public function getCachePath()
    {
        return $this->thumbCache->getCachePath($this->name, $this->width, $this->height, $this->format);
    }

    /**
     * Get the thumb image for manipulation
     * @return \Imagine\Image\ImageInterface
     */
    public function loadImage()
    {
        return Image::open($this->getCachePath());
    }
}
