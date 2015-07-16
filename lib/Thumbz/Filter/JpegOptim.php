<?php

namespace Thumbz\Filter;

use Imagine\Image\ImageInterface;
use Thumbz\Exception;

class JpegOptim extends AbstractFilter {

    protected $executable = "jpegoptim";
    protected $maxQuality = 100;
    protected $stripAll = true;
    protected $allProgressive = true;

    function __construct($maxQuality = 100)
    {
        $this->maxQuality = $maxQuality;
    }

    protected function _filter(ImageInterface $image)
    {
        $tempFile = tempnam("/tmp", "thumbz_jpegoptim");
        $image->save($tempFile, ["quality"=>100, "format" => "jpg"]);

        $executable = $this->getExecutable();
        $stripAll = $this->hasStripAll() ? "--strip-all" : "";
        $allProgressive = $this->hasAllProgressive() ? "--all-progressive" : "";
        $maxquality = $this->getMaxQuality();

        $command = "$executable --max=$maxquality $stripAll $allProgressive ".escapeshellarg($tempFile);
        exec($command, $output, $status);

        if($status>0){
            throw new Exception("Jpegoptim compression failed with the following command : '$command'. Is jpegoptim installed and runnable ? ");
        }

        $newImage = $this->getImagineAdapter()->load(file_get_contents($tempFile));
        unlink($tempFile);
        return $newImage;

    }

    /**
     * @return boolean
     */
    public function hasAllProgressive()
    {
        return $this->allProgressive;
    }

    /**
     * @param boolean $allProgressive
     */
    public function setAllProgressive($allProgressive)
    {
        $this->allProgressive = $allProgressive;
    }



    /**
     * @return string
     */
    public function getExecutable()
    {
        return $this->executable;
    }

    /**
     * @param string $executable
     */
    public function setExecutable($executable)
    {
        $this->executable = $executable;
    }

    /**
     * @return boolean
     */
    public function hasStripAll()
    {
        return $this->stripAll;
    }

    /**
     * @param boolean $stripAll
     */
    public function setStripAll($stripAll)
    {
        $this->stripAll = $stripAll;
    }



    /**
     * @return int
     */
    public function getMaxQuality()
    {
        return $this->maxQuality;
    }

    /**
     * @param int $maxQuality
     */
    public function setMaxQuality($maxQuality)
    {
        $this->maxQuality = $maxQuality;
    }



}