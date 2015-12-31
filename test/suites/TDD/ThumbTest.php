<?php

namespace Thumbz\Test;

use Imagine\Image\ImageInterface;
use Thumbz\Filter\FileFilterInterface;
use Thumbz\Filter\JpegOptim;
use Thumbz\Filter\PngQuant;
use Thumbz\PictureFinder\DirectoryPictureFinder;
use Thumbz\Exception;
use Thumbz\PictureFinderInterface;
use Thumbz\ThumbCache\DirectoryThumbCache;
use Thumbz\ThumbCache\FileCache;
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

    private function processThumb($format, FileFilterInterface $filter = null, $exifType)
    {

        $width = $height = 300;
        $name = "spongebob.jpg";


        $cacheItem = $this->thumbCache->getItem($name, $width, $height, $format);

        $this->assertFalse($cacheItem->cacheExists());

        $picture = $this->pictureFinder->findPicture($name);
        $thumb = $this->thumberMaker->generateThumb($picture, $width, $height);

        $cacheItem->setCache($thumb);
        $this->assertTrue($cacheItem->cacheExists());

        if ($filter) {
            $filter->filter($cacheItem->getCachePath());
        }

        $cachedFile = $cacheItem->getCachePath();

        $expectedName = $GLOBALS["cache-directory"] . "/$name.$width-$height.$format";
        $this->assertEquals($expectedName, $cachedFile);

        $this->assertEquals($exifType, exif_imagetype($cachedFile), "Image type invalide");

        if ($exifType) {
            $this->assertEquals([$width, $height], array_slice(getimagesize($cachedFile), 0, 2));
            $this->assertInstanceOf(ImageInterface::class, $cacheItem->loadImage());
        }



        // Test manual save for direct output
        $fileCache = new FileCache(sys_get_temp_dir(), 0);
        $fileName = tempnam(sys_get_temp_dir(), 'thumbzcache');
        $fileCache->cache($fileName, $format, $thumb);

        $filePath = $fileCache->getFullPath($fileName);

        if ($filter) {
            $filter->filter($filePath);
        }

        $this->assertEquals($exifType, exif_imagetype($filePath), "Image type invalide");

        if ($exifType) {
            $this->assertEquals([$width, $height], array_slice(getimagesize($filePath), 0, 2));
            $this->assertInstanceOf(ImageInterface::class, $cacheItem->loadImage());
        }

        unlink($filePath);

    }

    public function testThumbJpg()
    {
        $format = "jpg";
        $filter = new JpegOptim(80);
        $exifType = IMAGETYPE_JPEG;
        $this->processThumb($format, $filter, $exifType);
    }

    public function testThumbPng()
    {
        $format = "png";
        $filter = new PngQuant();
        $exifType = IMAGETYPE_PNG;
        $this->processThumb($format, $filter, $exifType);
    }

    public function testThumbGif()
    {
        $format = "gif";
        $filter = null;
        $exifType = IMAGETYPE_GIF;
        $this->processThumb($format, $filter, $exifType);
    }


    public function testThumbWebP()
    {
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
