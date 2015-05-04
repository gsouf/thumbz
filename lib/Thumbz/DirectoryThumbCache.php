<?php

namespace Thumbz;


use Thumbz\Exception\ImageCreationException;
use Thumbz\Exception\InvalidParamsException;
use Imagine\Image\ImageInterface;

class DirectoryThumbCache extends AbstractThumbCache {

    use PathProtectorTrait;

    /**
     * @var FileCache
     */
    protected $fileCache;


    function __construct($baseDirectory, $time = null)
    {
        if(null === $time){
            $time = 86400 * 7;
        }

        $this->fileCache = new FileCache($baseDirectory, $time);
    }

    /**
     * @param $params
     * @return ImageInterface
     * @throws Exception
     */
    public function cacheExists($name, $width, $height)
    {
        return $this->fileCache->isValid($this->getCacheName($name, $width, $height));
    }

    public function setCache($name, $width, $height, ImageInterface $data)
    {
        $fileName = $this->getCacheName($name, $width, $height);
        $this->fileCache->cache($fileName, $data);
    }

    public function getCache($name, $width, $height)
    {
        return file_get_contents($this->getCacheName($name, $width, $height));
    }


}