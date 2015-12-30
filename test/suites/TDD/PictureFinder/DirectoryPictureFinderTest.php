<?php

namespace Thumbz\Test\PictureFinder;

use Thumbz\Image;
use Thumbz\PictureFinder\DirectoryPictureFinder;

/**
 * @license see LICENSE
 */
class DirectoryPictureFinderTest extends \PHPUnit_Framework_TestCase
{

    public function testFind(){


        $pictureFinder = new DirectoryPictureFinder($GLOBALS["images-resources"]);
        $picture = $pictureFinder->findPicture("spongebob.jpg");
        $expectedPicture = Image::open($GLOBALS["images-resources"] . "/spongebob.jpg");

        $this->assertEquals($expectedPicture, $picture);

    }

}
