<?php

namespace Thumbz\Filter;

use Imagine\Image\ImageInterface;

abstract class AbstractFilter
{


    /**
     * @param ImageInterface $image
     */
    abstract public function filter($image);
}
