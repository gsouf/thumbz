<?php

namespace Thumbz\ThumbCache;

use Thumbz\AbstractThumbCache;
use Thumbz\Exception;
use Imagine\Image\ImageInterface;
use Thumbz\ThumbCacheItem;

class DirectoryThumbCache extends AbstractThumbCache
{

    /**
     * @var FileCache
     */
    protected $fileCache;


    function __construct($baseDirectory, $time = null)
    {
        if (null === $time) {
            $time = 86400 * 7;
        }

        $this->fileCache = new FileCache($baseDirectory, $time);
    }

    /**
     * @param $params
     * @return bool
     * @throws Exception
     */
    public function cacheExists(ThumbCacheItem $cacheItem)
    {
        return $this->fileCache->isValid($cacheItem->getCacheName());
    }

    public function setCache(ThumbCacheItem $cacheItem, ImageInterface $data)
    {
        $fileName = $cacheItem->getCacheName();
        $this->fileCache->cache($fileName, $cacheItem->getFormat(), $data);
    }

    public function getCache(ThumbCacheItem $cacheItem)
    {
        $path = $cacheItem->getCacheName();
        return $this->fileCache->getCache($path);
    }


    public function flushAll()
    {
        $path = $this->fileCache->getDir();

        if (file_exists($path)) {

            foreach (new \DirectoryIterator($path) as $fileInfo) {
                if (!$fileInfo->isDot()) {
                    unlink($fileInfo->getPathname());
                }
            }

        }

    }

    public function getCachePath(ThumbCacheItem $cacheItem)
    {
        $name = $cacheItem->getCacheName();
        return $this->fileCache->pathProtectorProtect($name);
    }
}
