<?php
/**
 * @license see LICENSE
 */

namespace Thumbz;

class ThumbCacheItem
{

    protected $name;
    protected $format;

    /**
     * @var AbstractThumbCache
     */
    protected $thumbCache;


    protected $cacheName = null;

    /**
     * CacheItem constructor.
     * @param string $name name of the image
     * @param int $width width of the thumbnail
     * @param int $height height of the thumbnail
     * @param string $format format of the thumbnail (jpg, png, gif..)
     * @param AbstractThumbCache $cacheAdapter cache interface
     */
    public function __construct($cacheName, $format, AbstractThumbCache $cacheAdapter)
    {
        $this->name = $cacheName;
        $this->format = $format;
        $this->thumbCache = $cacheAdapter;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }



    /**
     * Check if a cache exists for the item
     * @return bool
     */
    public function cacheExists()
    {
        return $this->thumbCache->cacheExists($this);
    }

    public function getCacheName(){
        return $this->name;
    }

    /**
     * Save the data
     * @param $data
     */
    public function setCache($data)
    {
        $this->thumbCache->setCache($this, $data);
    }


    /**
     * Get the path to the cached file
     * @return mixed
     */
    public function getCachePath()
    {
        return $this->thumbCache->getCachePath($this);
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
