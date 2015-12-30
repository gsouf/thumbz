<?php
/**
 * @license see LICENSE
 */

namespace Thumbz\PictureFinder;


use Thumbz\PictureFinderInterface;

class ClosurePictureFinder implements PictureFinderInterface
{

    protected $handler;

    /**
     * ClosurePictureFinder constructor.
     * @param callable $handler the function that finds the picture
     */
    public function __construct(callable $handler)
    {
        $this->handler = $handler;
    }


    public function findPicture($name)
    {
        return call_user_func($this->handler, $name);
    }


}