<?php

namespace Thumbz;


use Imagine\Image\ImagineInterface;
use Imagine\Gd\Imagine;
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