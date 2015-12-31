<?php

namespace Thumbz\Filter;

use Imagine\Image\ImageInterface;

interface FileFilterInterface
{


    /**
     * @param ImageInterface $image
     */
    public function filter($image);
}
