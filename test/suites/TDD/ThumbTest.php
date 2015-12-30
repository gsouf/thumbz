<?php

namespace Thumbz\Test;

use Thumbz\Filter\AbstractFilter;
use Thumbz\Filter\JpegOptim;
use Thumbz\Filter\PngQuant;
use Thumbz\PictureFinder\DirectoryPictureFinder;
use Thumbz\Exception;
use Thumbz\PictureFinderInterface;
use Thumbz\ThumbCache\DirectoryThumbCache;
use Thumbz\ThumbMaker;

class ThumbGenerationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DirectoryThumbCache
     */
    protected $thumbCache;

    /**
     * @var PictureFinderInterface
     */
    protected $pictureFinder;

    /**
     * @var ThumbMaker
     */
    protected $thumberMaker;

    public function setUp()
    {
        $this->thumbCache = new DirectoryThumbCache($GLOBALS["cache-directory"]);
        $this->pictureFinder = new DirectoryPictureFinder($GLOBALS["images-resources"]);
        $this->thumberMaker = new ThumbMaker();
        $this->thumbCache->flushAll();
    }

    private function processThumb($format, AbstractFilter $filter = null, $exifType){

        $width = $height = 300;
        $name = "spongebob.jpg";

        $this->assertFalse($this->thumbCache->cacheExists($name, $width, $height, $format));

        if(!$this->thumbCache->cacheExists($name, $width, $height, $format)) {
            $picture = $this->pictureFinder->findPicture($name);
            $thumb = $this->thumberMaker->generateThumb($picture, $width, $height);

            $this->thumbCache->setCache($name, $width, $height, $format, $thumb);

            $this->assertTrue($this->thumbCache->cacheExists($name, $width, $height, $format));

            if ($filter) {
                $filter->filter($this->thumbCache->getCachePath($name, $width, $height, $format));
            }
        }

        $cachedFiled = $this->thumbCache->getCachePath($name, $width, $height, $format);

        $this->assertEquals($exifType, exif_imagetype($cachedFiled), "Image type invalide");

        if($exifType) {
            $this->assertEquals([$width, $height], array_slice(getimagesize($cachedFiled), 0, 2));
        }
    }

    public function testThumbJpg(){
        $format = "jpg";
        $filter = new JpegOptim(80);
        $exifType = IMAGETYPE_JPEG;
        $this->processThumb($format, $filter, $exifType);
    }

    public function testThumbPng(){
        $format = "png";
        $filter = new PngQuant();
        $exifType = IMAGETYPE_PNG;
        $this->processThumb($format, $filter, $exifType);
    }

    public function testThumbGif(){
        $format = "gif";
        $filter = null;
        $exifType = IMAGETYPE_GIF;
        $this->processThumb($format, $filter, $exifType);
    }


    public function testThumbWebP(){
        $format = "webp";
        $filter = null;
        $exifType = false;
        $this->processThumb($format, $filter, $exifType);
    }

    public function tearDown()
    {
        $this->thumbCache->flushAll();
    }

}

