Small library that helps to manage thumbs creation and caches using the [imagine library](https://imagine.readthedocs.org)

[![Build Status](https://travis-ci.org/gsouf/thumbz.svg)](https://travis-ci.org/gsouf/thumbz)
[![Test Coverage](https://codeclimate.com/github/gsouf/thumbz/badges/coverage.svg)](https://codeclimate.com/github/gsouf/thumbz/coverage)
[![Latest Stable Version](https://poser.pugx.org/gsouf/thumbz/v/stable)](https://packagist.org/packages/gsouf/thumbz)

Usage
-----

```php

use Thumbz\Filter\JpegOptim;
use Thumbz\PictureFinder\DirectoryPictureFinder;
use Thumbz\ThumbCache\DirectoryThumbCache;
use Thumbz\ThumbMaker;


$width = $height = 100; // with and height of the picture final thumbnail
$name = "spongebob.jpg"; // name of the original picture
$format = "jpg"; // format of the thumb

// DrectoryThumbCache will write/read the images in the cache
$thumbCache = new DirectoryThumbCache("cache/thumbnails");

if(!$thumbCache->cacheExists($name, $width, $height, $format)){
    
    // DirectoryPictureFinder helps to find and load pictures from a base directory
    $pictureFinder = new DirectoryPictureFinder("asset/images");
    
    // ThumbMaker will create the thumb from an original image
    $thumberMaker = new ThumbMaker();
    
    // find the picture (that will be asset/images/spongebob.jpg)
    $picture = $pictureFinder->findPicture($name);
    
    // create the thumbnail
    $thumb = $thumberMaker->generateThumb($picture, $width, $height);
    
    // cache the thumbnail
    $thumbCache->setCache($name, $width, $height, $format, $thumb);
    
    // Optimize it
    $filter = new JpegOptim(80);
    $filter->filter($this->thumbCache->getCachePath($name, $width, $height, $format));
}

// Now you can serve the file
$cacheFiled = $thumbCache->getCacheName($name, $width, $height, $format);


```


About caching
-------------

The library focuses on filesystem caching, it's a way better for image to be cached on the file system rather than 
in some memory database.


About webp support
-------------------

Currently php support for webp is fairly random.
 
This library made the choice to forget the native php support and instead uses the 
[cwebp](https://developers.google.com/speed/webp/docs/cwebp) command. You will need it to be install on your system 
or the library wont be able to encode the image with webp.
