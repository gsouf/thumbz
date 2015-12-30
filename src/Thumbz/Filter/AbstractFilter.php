<?php

namespace Thumbz\Filter;


use Imagine\Image\ImageInterface;

abstract class AbstractFilter {


    /**
     * @param ImageInterface $image
     */
    public function filter($image){
        return $this->_filter($image);
    }

    abstract protected function _filter($image);

}