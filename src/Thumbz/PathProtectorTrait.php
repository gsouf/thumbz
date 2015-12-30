<?php

namespace Thumbz;

use Thumbz\Exception\RootPathViolationException;

trait PathProtectorTrait
{

    protected $basePathProtector;

    protected function pathProtectorSetBase($path)
    {
        $path = rtrim($path);
        $this->basePathProtector = $this->__pathProtectorTruePath($path) . "/";
    }

    public function pathProtectorGetBase()
    {
        return $this->basePathProtector;
    }

    public function pathProtectorProtect($path)
    {

        if (!$this->basePathProtector) {
            return $path;
        }

        $basePath = $this->basePathProtector;

        // this is the path we want to protect
        $newPath = $path{0} == "/" ? $path : $basePath . $path;
        $newPath = $this->__pathProtectorTruePath($newPath);

        if (substr($newPath, 0, strlen($basePath)) === $basePath) {
            return $newPath;
        } else {
            throw new RootPathViolationException("Tried to access a file outside of the following root path : $basePath");
        }


    }

    /**
     * from http://stackoverflow.com/a/4050444/1278479
     * @param $path
     * @return mixed|string
     */
    private function __pathProtectorTruePath($path)
    {
            // whether $path is unix or not
            $unipath=strlen($path)==0 || $path{0}!='/';
            // attempts to detect if path is relative in which case, add cwd
        if (strpos($path, ':')===false && $unipath) {
            $path=getcwd().DIRECTORY_SEPARATOR.$path;
        }
            // resolve path parts (single dot, double dot and double delimiters)
            $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
            $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
            $absolutes = [];
            foreach ($parts as $part) {
                if ('.'  == $part) {
                    continue;
                }
                if ('..' == $part) {
                    array_pop($absolutes);
                } else {
                    $absolutes[] = $part;
                }
            }
            $path=implode(DIRECTORY_SEPARATOR, $absolutes);
            // resolve any symlinks
            if (file_exists($path) && linkinfo($path)>0) {
                $path=readlink($path);
            }
            // put initial separator that could have been lost
            $path=!$unipath ? '/'.$path : $path;
            return $path;
    }
}
