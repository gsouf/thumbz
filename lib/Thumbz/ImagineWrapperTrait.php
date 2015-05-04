<?php

namespace Thumbz;


use Imagine\Gd\Imagine;
use Imagine\Image\ImagineInterface;

trait ImagineWrapperTrait {

    /**
     * @var ImagineInterface
     */
    protected $imagineAdapter;

    /**
     * @return ImagineInterface
     */
    public function getImagineAdapter()
    {

        if(null == $this->imagineAdapter){
            $this->imagineAdapter = new \Imagine\Imagick\Imagine();
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