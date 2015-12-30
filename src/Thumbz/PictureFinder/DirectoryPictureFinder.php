<?php

namespace Thumbz\PictureFinder;

use Thumbz\Image;
use Thumbz\PathProtectorTrait;
use Thumbz\PictureFinderInterface;

/**
 * @license see LICENSE
 */
class DirectoryPictureFinder implements PictureFinderInterface
{

    use PathProtectorTrait;


    /**
     * DirectoryPictureFinder constructor.
     */
    public function __construct($directory)
    {
        $this->pathProtectorSetBase($directory);
    }

    public function findPicture($name)
    {
        return Image::open($this->pathProtectorProtect($name));
    }
}
