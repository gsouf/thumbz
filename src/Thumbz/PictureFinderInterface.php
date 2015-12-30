<?php
/**
 * @license see LICENSE
 */

namespace Thumbz;


use Imagine\Image\ImageInterface;

interface PictureFinderInterface
{

    /**
     * @param string $name name or identifier of the image
     * @return ImageInterface the image to make a thumb of
     */
    public function findPicture($name);

}