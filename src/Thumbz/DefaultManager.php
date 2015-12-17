<?php

namespace Thumbz;


use Thumbz\ThumbSender\RawBytesSender;

class DefaultManager {


    /**
     * @var DirectoryPictureFinder
     */
    protected $pictureFinder;

    /**
     * @var DirectoryThumbCache
     */
    protected $thumbCache;

    /**
     * @var ThumbMaker
     */
    protected $thumbMaker;

    /**
     * @var AbstractThumbSender
     */
    protected $thumbSender;


    function __construct($originalDir, $cacheDir, $thumbOptions){

        $this->pictureFinder = new DirectoryPictureFinder($originalDir);
        $this->thumbCache  = new DirectoryThumbCache($cacheDir);
        $this->thumbMaker    = new \Thumbz\ThumbMaker($thumbOptions);
        $this->thumbSender   = new RawBytesSender(86400*7);

    }


    public function send($pictureName, $width, $height){

        if( ! $this->thumbCache->cacheExists($pictureName, $width, $height)){
            $image = $this->$pictureFinder->findImage($pictureName);
            $thumb = $this->thumbMaker->generateThumb($image, $width, $height);
            $this->thumbCache->setCache($pictureName, $width, $height, $thumb);
        }

        $thumb = new Thumb($pictureName, $width, $height, $this->thumbCache);

        $this->thumbSender->send($thumb);

    }


}