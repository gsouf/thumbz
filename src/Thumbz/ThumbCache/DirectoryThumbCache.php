<?php

namespace Thumbz\ThumbCache;

use Thumbz\AbstractThumbCache;
use Thumbz\Exception;
use Imagine\Image\ImageInterface;

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
    public function cacheExists($name, $width, $height, $format)
    {
        return $this->fileCache->isValid($this->getCacheName($name, $width, $height, $format));
    }

    public function setCache($name, $width, $height, $format, ImageInterface $data)
    {
        $fileName = $this->getCacheName($name, $width, $height, $format);
        $this->fileCache->cache($fileName, $format, $data);
    }

    public function getCache($name, $width, $height, $format)
    {
        $path = $this->getCacheName($name, $width, $height, $format);
        return $this->fileCache->getCache($path);
    }


    public function flushAll()
    {
        $path = $this->fileCache->getDir();

        foreach (new \DirectoryIterator($path) as $fileInfo) {
            if (!$fileInfo->isDot()) {
                unlink($fileInfo->getPathname());
            }
        }

    }

    public function getCachePath($name, $width, $height, $format)
    {
        $name = $this->getCacheName($name, $width, $height, $format);
        return $this->fileCache->pathProtectorProtect($name);
    }
}
