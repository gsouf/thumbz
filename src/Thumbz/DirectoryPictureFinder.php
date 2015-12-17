<?php

namespace Thumbz;


use Thumbz\Exception\ImageCreationException;
use Thumbz\Exception\InvalidParamsException;

class DirectoryPictureFinder extends AbstractPictureFinder {

    use PathProtectorTrait;
    use ImagineWrapperTrait;

    function __construct($baseDirectory)
    {
        $this->pathProtectorSetBase($baseDirectory);
    }


    /**
     * @inheritdoc
     */
    public function findImage($name)
    {
        $path = $this->pathProtectorProtect($name);


        if(!file_exists($path)){
            throw new InvalidParamsException("File does not exists : $path");
        }

        try{
            $image = $this->getImagineAdapter()->open($path);
        }catch(ImageCreationException $e){
            throw new ImageCreationException("Image could not be opened", 0, $e);
        }

        return $image;
    }

}