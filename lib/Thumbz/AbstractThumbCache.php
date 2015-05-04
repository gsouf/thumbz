<?php

namespace Thumbz;


use Imagine\Gd\Imagine;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;

abstract class AbstractThumbCache {

    /**
     * @param $params
     * @return ImageInterface
     * @throws Exception
     */
    abstract public function cacheExists($name, $width, $height);

    abstract public function setCache($name, $width, $height, ImageInterface $data);

    abstract public function getCache($name, $width, $height);


    public function getCacheName($name, $width, $height){
        $path = $name . "_" . $width . "_" . $height . ".jpg";
        return $path;
    }


    protected $imagineAdapter;

    /**
     * @return ImagineInterface
     */
    public function getImagineAdapter()
    {

        if(null == $this->imagineAdapter){
            $this->imagineAdapter = new Imagine();
        }

        return $this->imagineAdapter;
    }

    /**
     * @param ImagineInterface $imagineAdapter
     */
    public function setImagineAdapter(ImagineInterface $imagineAdapter)
    {
        $this->imagineAdapter = $imagineAdapter;
    }

}