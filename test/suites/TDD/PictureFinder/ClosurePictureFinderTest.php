<?php
/**
 * @license see LICENSE
 */

namespace Thumbz\Test\PictureFinder;

use Thumbz\PictureFinder\ClosurePictureFinder;
use Thumbz\Image;

class ClosurePictureFinderTest extends \PHPUnit_Framework_TestCase
{

    public function testFind()
    {


        $pictureFinder = new ClosurePictureFinder(function ($name) {
            return Image::open($GLOBALS["images-resources"] . "/$name");
        });
        $picture = $pictureFinder->findPicture("spongebob.jpg");
        $expectedPicture = Image::open($GLOBALS["images-resources"] . "/spongebob.jpg");

        $this->assertEquals($expectedPicture, $picture);

    }
}
