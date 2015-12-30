<?php

namespace Thumbz;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Palette\RGB;
use Imagine\Image\Point;
use Imagine\Imagick\Imagine;
use Thumbz\Filter\AbstractFilter;

class ThumbMaker
{

    protected $options;

    /**
     * available options :
     *
     * - background : the background color of the picture, useful when using fitSize option. Default : transparent
     * - fitSize : the picture will fit the size if the proportion are not the same.
     * The background color will be used to fill the empty area
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }




    /**
     * @param ImageInterface $image
     * @return ImageInterface
     */
    public function generateThumb(ImageInterface $image, $width, $height)
    {

        $background = isset($this->options["background"]) ? $this->options["background"] : null;
        $fitSize    = isset($this->options["fitSize"])    ? $this->options["fitSize"]    : true;

        $sizeBox   = new Box($width, $height);
        $thumbMode = ImageInterface::THUMBNAIL_INSET;

        $thumb = $image
            ->thumbnail($sizeBox, $thumbMode);

        // fill the area
        if ($fitSize) {

            $palette = new RGB();

            if (!$background || $background == "transparent") {
                $backgroundColor = $palette->color("fff", 1);
            } else {
                $backgroundColor = $palette->color($background);
            }

            // source http://harikt.com/blog/2012/12/17/resize-image-keeping-aspect-ratio-in-imagine/
            $realThumb  =  Image::create($sizeBox, $backgroundColor);

            $sizeR     = $thumb->getSize();
            $widthR    = $sizeR->getWidth();
            $heightR   = $sizeR->getHeight();

            $startX = $startY = 0;
            if ($widthR < $width) {
                $startX = ( $width - $widthR ) / 2;
            }
            if ($heightR < $height) {
                $startY = ( $height - $heightR ) / 2;
            }

            $realThumb->paste($thumb, new Point($startX, $startY));

        } else {
            $realThumb = $thumb;
        }

        return $realThumb;

    }
}
