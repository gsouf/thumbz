<?php

namespace Thumbz\Filter;

use \Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;
use Thumbz\ImagineWrapperTrait;

abstract class AbstractFilter {

    use ImagineWrapperTrait;

    /**
     * @var ImagineInterface
     */
    protected $imagineAdapter;


    /**
     * @param ImageInterface $image
     */
    public function filter(ImageInterface $image){
        return $this->_filter($image);
    }

    abstract protected function _filter(ImageInterface $image);

}