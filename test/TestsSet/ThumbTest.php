<?php

use Thumbz\DirectoryPictureFinder;
use Thumbz\Exception;
use Thumbz\DirectoryThumbCache;


class ThumbTest extends PHPUnit_Framework_TestCase{

    public function testThumb(){


        $pictureName = "spongebob.png";
        $width = 100;
        $height = 100;


        $pictureFinder = new DirectoryPictureFinder(__DIR__ . "/../resources/img");
        $pictureCache  = new DirectoryThumbCache(__DIR__ . "/../resources/cache");
        $thumbMaker    = new \Thumbz\ThumbMaker(["background" => "#FFFFFF", "fitSize" => true, "pngquant" => true]);



        try{
            if( ! $pictureCache->cacheExists($pictureName, $width, $height)){

                $image = $pictureFinder->findImage($pictureName);
                $thumb = $thumbMaker->generateThumb($image, $width, $height);

                $pictureCache->setCache($pictureName, $width, $height, $thumb);

            }
        }catch(Exception $e){
            var_dump($e->getMessage());
        }

    }

}

