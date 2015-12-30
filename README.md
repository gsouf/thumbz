Small library that helps to manage thumbs creation and caches using the [imagine library](https://imagine.readthedocs.org)

[![Build Status](https://travis-ci.org/gsouf/thumbz.svg)](https://travis-ci.org/gsouf/thumbz)
[![Test Coverage](https://codeclimate.com/github/gsouf/thumbz/badges/coverage.svg)](https://codeclimate.com/github/gsouf/thumbz/coverage)



Usage
-----

```php

$thumbCache = new DirectoryThumbCache($GLOBALS["cache-directory"]);
$pictureFinder = new DirectoryPictureFinder($GLOBALS["images-resources"]);
$thumberMaker = new ThumbMaker();

$width = $height = 100;
$name = "spongebob.jpg";
$format = "jpg";
$filter = new JpegOptim(80);



if(!$thumbCache->cacheExists($name, $width, $height, $format)){
    $picture = $pictureFinder->findPicture($name);
    $thumb = $thumberMaker->generateThumb($picture, $width, $height);
    $thumbCache->setCache($name, $width, $height, $format, $thumb);
    $thumb = $filter->filter($this->thumbCache->getCachePath($name, $width, $height, $format));
}

$cacheFiled = $thumbCache->getCacheName($name, $width, $height, $format);


```


Webp support
------------

Currently php support for webp is random. The library forgets about the native php support and instead uses the 
[cwebp](https://developers.google.com/speed/webp/docs/cwebp) command. You will need it to be install on your system 
or the library wont be able to encode the image with webp.
