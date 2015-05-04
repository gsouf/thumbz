<?php

namespace Thumbz;

use Imagine\Image\ImageInterface;

abstract class AbstractPictureFinder {

    /**
     * @param $params
     * @return ImageInterface
     * @throws Exception
     */
    abstract public function findImage($name);




}