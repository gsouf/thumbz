<?php

namespace Thumbz;


class Thumb {

    protected $pictureName;
    protected $width;
    protected $height;
    protected $cacheAdapter;

    protected $cacheName;

    protected $data = null;

    function __construct($pictureName, $width, $height, AbstractThumbCache $cacheAdapter)
    {
        $this->pictureName = $pictureName;
        $this->width = $width;
        $this->height = $height;
        $this->cacheAdapter = $cacheAdapter;
        $this->cacheName = $cacheAdapter->getCacheName($pictureName, $width, $height);
    }

    /**
     * @return mixed
     */
    public function getPictureName()
    {
        return $this->pictureName;
    }

    public function getExtension(){
        $pieces = explode(".", $this->cacheName);
        return array_pop($pieces);
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return AbstractThumbCache
     */
    public function getCacheAdapter()
    {
        return $this->cacheAdapter;
    }

    /**
     * @return string
     */
    public function getCacheName()
    {
        return $this->cacheName;
    }

    /**
     * @return string
     */
    public function getData()
    {
        if(null === $this->data){
            $this->data = $this->cacheAdapter->getCache($this->getPictureName(), $this->getWidth(), $this->getHeight());
        }

        return $this->data;
    }




}