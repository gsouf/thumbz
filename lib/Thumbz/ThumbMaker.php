<?php

namespace Thumbz;


use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Color;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Point;

class ThumbMaker {

    protected $options;

    use ImagineWrapperTrait;

    /**
     * available options :
     *
     * - background : the background color of the picture, useful when using fitSize option. Default : transparent
     * - fitSize : the picture will fit the size if the proportion are not the same. The background color will be used to fill the empty area
     * - pngquant : the image should be compressed with pngquant. Be aware that it wont force the final image to be a png. Default : false
     * - pngquant-bin : the pngquant binary. Default : pngquant
     * - pngquant-quality-max : the max quality for pngquant. Default 100
     * - pngquant-quality-min : the min quality for pngquant. Default 80
     */
    function __construct($options){
        $this->options = $options;
    }


    /**
     * @param ImageInterface $image
     */
    public function generateThumb($image, $width, $height){

        $background = isset($this->options["background"]) ? $this->options["background"] : null;
        $fitSize    = isset($this->options["fitSize"])    ? $this->options["fitSize"]    : true;

        $sizeBox   = new Box($width, $height);
        $thumbMode = ImageInterface::THUMBNAIL_INSET;

        $thumb = $image
            ->thumbnail($sizeBox, $thumbMode);

        // fill the area
        if($fitSize){

            if( !$background || $background == "transparent"){
                $backgroundColor = new Color("fff",1);
            }else{
                $backgroundColor = new Color($background);
            }

            // source http://harikt.com/blog/2012/12/17/resize-image-keeping-aspect-ratio-in-imagine/
            $realThumb  = $this->getImagineAdapter()->create($sizeBox, $backgroundColor);

            $sizeR     = $thumb->getSize();
            $widthR    = $sizeR->getWidth();
            $heightR   = $sizeR->getHeight();

            $startX = $startY = 0;
            if ( $widthR < $width ) {
                $startX = ( $width - $widthR ) / 2;
            }
            if ( $heightR < $height ) {
                $startY = ( $height - $heightR ) / 2;
            }

            $realThumb->paste($thumb, new Point($startX, $startY));

        }else{
            $realThumb = $thumb;
        }

        $realThumb = $this->__makePngQuant($realThumb);

        return $realThumb;

    }

    private function __makePngQuant(ImageInterface $realThumb){
        if( isset($this->options["pngquant"]) && $this->options["pngquant"] ){

            $tempFile = tempnam("/tmp", "thumbz_quant");
            $realThumb->save($tempFile, ["quality"=>100, "format" => "png"]);



            $executable = isset($this->options["pngquant-bin"]) ? $this->options["pngquant-bin"] : "pngquant";
            $maxquality = isset($this->options["pngquant-quality-max"]) ? $this->options["pngquant-quality-max"] : 100;
            $minquality = isset($this->options["pngquant-quality-min"]) ? $this->options["pngquant-quality-min"] : 80;

            if($minquality > $maxquality){
                $minquality = $maxquality;
            }

            $command = "pngquant --quality=$minquality-$maxquality - < ".escapeshellarg(    $tempFile);
            $compressed = shell_exec($command);

            if (!$compressed) {
                throw new Exception("Pngquant compression failed with the following command : '$command'. Is pngquant 1.8+ installed on the server ? ");
            }

            unlink($tempFile);
            return $this->getImagineAdapter()->load($compressed);
        }

        return $realThumb;
    }


}