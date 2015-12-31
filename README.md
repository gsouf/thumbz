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


$width = $height = 100; // width and height of the picture final thumbnail
$name = "spongebob.jpg"; // name of the original picture
$format = "jpg"; // format of the thumb

// DrectoryThumbCache will write/read the images in the cache
$thumbCache = new DirectoryThumbCache("cache/thumbnails");

// cache item will make work with cache easier 
$cacheItem = $thumbCache->getItem($name, $width, $height, $format);

if(!$cacheItem->cacheExists()){
    
    // DirectoryPictureFinder helps to find and load pictures from a base directory
    $pictureFinder = new DirectoryPictureFinder("asset/images");
    
    // ThumbMaker will create the thumb from an original image
    $thumberMaker = new ThumbMaker();
    
    // find the picture (that will be asset/images/spongebob.jpg)
    $picture = $pictureFinder->findPicture($name);
    
    // create the thumbnail
    $thumb = $thumberMaker->generateThumb($picture, $width, $height);
    
    // cache the thumbnail
    $cacheItem->setCache($thumb);
    
    // Optimize it
    $filter = new JpegOptim(80);
    $filter->filter($cacheItem->getCachePath());
}

// You might output the image
$cacheFile = $cacheItem->getCachePath();

```

Note about performances
-----------------------

If you work behind some static resource server like varnish, you might not cache the thumb and only serve it 
to varnish that will cache on its one way. 

Then the following example can be what you want:

```php

use Thumbz\Filter\JpegOptim;
use Thumbz\PictureFinder\DirectoryPictureFinder;
use Thumbz\ThumbMaker;
use Thumbz\ThumbCache\FileCache;


$width = $height = 100;
$name = "spongebob.jpg";
$format = "jpg";

$pictureFinder = new DirectoryPictureFinder("asset/images");
// find the picture (that will be asset/images/spongebob.jpg)
$picture = $pictureFinder->findPicture($name);

$thumberMaker = new ThumbMaker();
$thumb = $thumberMaker->generateThumb($picture, $width, $height);


// Save a temp file
// That's a workaround to allow external filtering and webp support
$fileCache = new FileCache(sys_get_temp_dir(), 0);
$fileName = tempnam(sys_get_temp_dir(), 'thumbzcache');
$fileCache->cache($fileName, $format, $thumb);

$filePath = $fileCache->getFullPath($fileName);

header("Content-Type: image/$format");
echo file_get_contents("$filePath");
unlink($filePath);

```


File system Cache
-----------------

The library focuses on filesystem caching, it's a way better for image to be cached on the file system rather than 
in some memory database.


About webp support
-------------------

Currently php support for webp is fairly bad.
 
This library partially supports webp and uses
[cwebp](https://developers.google.com/speed/webp/docs/cwebp) command for webp thumb generation. You will need it to be install on your system 
or the library wont be able to encode the image with webp.

The support is only partial and will only work when writing a file in the cache in webp format. 

