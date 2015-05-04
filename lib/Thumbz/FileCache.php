<?php


namespace Thumbz;

use Imagine\Image\ImageInterface;

/**
 * FileCache
 *
 * @author sghzal
 */
class FileCache {

    use PathProtectorTrait;

    protected $time;
    
    public function __construct($dir,$time) {
        if($dir{strlen($dir)-1} != "/")
            $dir = $dir . "/";
        
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

    public function cache($path, ImageInterface $data){
        $path = $this->getFullPath($path);
        $this->_prepareDirectoryForFile($path);
        $data->save($path, array('quality' => 100));
    }
    
    private function _prepareDirectoryForFile($path){
        $dirs = substr($path, 0, strrpos( $path, '/') );
        if(!file_exists($dirs)){
            mkdir($dirs, 0777, true);
        }
    }
    
}