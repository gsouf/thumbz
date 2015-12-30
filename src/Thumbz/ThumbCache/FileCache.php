<?php


namespace Thumbz\ThumbCache;

use Imagine\Exception\RuntimeException;
use Imagine\Image\ImageInterface;
use Thumbz\Exception;
use Thumbz\Filter\Cwebp;
use Thumbz\PathProtectorTrait;

/**
 * FileCache
 *
 * @author sghzal
 */
class FileCache {

    use PathProtectorTrait;

    protected $time;


    public function __construct($dir, $time) {
        $this->pathProtectorSetBase($dir);
        $this->time=$time;
    }


    /**
     * Check if the cache exists and is valid
     * @param string $path the prepared path
     * @return boolean
     */
    public function isValid($path){

        $fullPath = $this->getFullPath($path);

        if(file_exists($fullPath)){

            if($this->_fileExpired($fullPath)){
                return false;
            }else{
                return true;
            }

        }else{
            return false;
        }

    }

    /**
     * check if file is expired (should be checked for existance before)
     * @param string $path
     * @return bool
     */
    private function _fileExpired($path){
        $existsSince = time() - filemtime($path);
        return $existsSince > $this->getCacheTime();
    }

    public function getDir() {
        return $this->pathProtectorGetBase();
    }

    public function getCacheTime() {
        return $this->time;
    }

    public function getFullPath($path){
        return $this->pathProtectorProtect($path);
    }

    public function cache($path, $format, ImageInterface $data){
        $path = $this->getFullPath($path);
        $this->_prepareDirectoryForFile($path);

        if($format == "webp"){
            $data->save($path, ["quality" => 100,  "format" => "png"]);

            $cwebp = new Cwebp();
            try{
                $cwebp->filter($path);
            }catch(Exception $e){
                unlink($path);
                throw new RuntimeException($e->getMessage());
            }

        } else {
            $data->save($path, ["quality" => 100,  "format" => $format]);
        }


        chmod($path, 0777);
    }

    public function getCache($path){
        return file_get_contents($this->pathProtectorProtect($path));
    }

    private function _prepareDirectoryForFile($path){
        $dirs = substr($path, 0, strrpos( $path, '/') );
        if(!file_exists($dirs)){
            $oldUM = umask(0);
            mkdir($dirs, 0777, true);
            umask($oldUM);
        }
    }

}