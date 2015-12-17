<?php

use Thumbz\DirectoryPictureFinder;
use Thumbz\Exception;
use Thumbz\DirectoryThumbCache;


class ThumbTest extends PHPUnit_Framework_TestCase{

    public function testThumb(){


        $pictureName = "spongebob.jpg";
        $width = 100;
        $height = 100;



        $pictureFinder = new DirectoryPictureFinder(__DIR__ . "/../../resources/img");

        // PNG MAKER
        $pictureCachePng  = new DirectoryThumbCache(__DIR__ . "/../../resources/cache");
        $pictureCachePng->setOuputFormat("png");
        $thumbMakerPng    = new \Thumbz\ThumbMaker(["background" => "#FFFFFF", "fitSize" => true]);
        $thumbMakerPng->addFilter(new \Thumbz\Filter\PngQuant());

        // JPG MAKER
        $pictureCacheJpg  = new DirectoryThumbCache(__DIR__ . "..//../resources/cache");
        $pictureCacheJpg->setOuputFormat("jpg");
        $thumbMakerJpg    = new \Thumbz\ThumbMaker(["background" => "#FFFFFF", "fitSize" => true]);
        $thumbMakerJpg->addFilter(new \Thumbz\Filter\JpegOptim(80));

        try{

            $pictureCache = $pictureCacheJpg;
            $thumbMaker   = $thumbMakerJpg;

            if( ! $pictureCache->cacheExists($pictureName, $width, $height)){

                $image = $pictureFinder->findImage($pictureName);
                $thumb = $thumbMaker->generateThumb($image, $width, $height);

                $pictureCache->setCache($pictureName, $width, $height, $thumb);

            }
        }catch(Exception $e){
            $this->fail($e->getMessage());
        }

    }

}

