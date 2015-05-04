<?php

namespace Thumbz;


use Imagine\Gd\Imagine;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;

abstract class AbstractThumbCache {

    protected $ouputFormat = "png";

    /**
     * @param $params
     * @return ImageInterface
     * @throws Exception
     */
    abstract public function cacheExists($name, $width, $height);

    abstract public function setCache($name, $width, $height, ImageInterface $data);

    abstract public function getCache($name, $width, $height);


    public function getCacheName($name, $width, $height){
        $path = $name . "." . $width . "-" . $height . "." . $this->ouputFormat;
        return $path;
    }

    /**
     * default to png
     * @return string
     */
    public function getOuputFormat()
    {
        return $this->ouputFormat;
    }

    /**
     * default to png
     * @param string $ouputFormat
     */
    public function setOuputFormat($ouputFormat)
    {
        $this->ouputFormat = $ouputFormat;
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