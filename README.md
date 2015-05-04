BIG PICTURE
===========

Big picture is a small php library that helps to manage picture thumbs creation and caching (server and client)



Usage Example
-------------

```php

    use Thumbz\DirectoryPictureFinder;
    use Thumbz\ParamsException;

    $pictureFinder = new DirectoryPictureFinder("path/to/original/pictures/dir");
    $pictureCache  = new DirectoryPictureCache("path/to/cache/pictures/dir");
    $pictureSender = new HttpCachePictureSender(86400);

    try{
        $picture = $pictureFinder->findPicture($params);
        if($picture){
            $thumb = $pictureCache->generateThumb($picture, 80, 80, [
            
                "background" => "#FFFFFF", // the background is white
                "fitSize"    => true       // the picture will fit the size we want
            
            ]);
            
            $pictureSender->send($thumb);
            
        }else{
            // picture does not exist
        }
    }catch(ParamsException $e){
        // 
    }
    

```