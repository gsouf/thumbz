<?php

namespace Thumbz\Filter;

use Thumbz\Exception;

class JpegOptim extends AbstractFilter
{

    protected $executable = "jpegoptim";
    protected $maxQuality = 100;
    protected $stripAll = true;
    protected $allProgressive = true;

    public function __construct($maxQuality = 100)
    {
        $this->maxQuality = $maxQuality;
    }

    public function filter($image)
    {

        $executable = $this->getExecutable();
        $stripAll = $this->hasStripAll() ? "--strip-all" : "";
        $allProgressive = $this->hasAllProgressive() ? "--all-progressive" : "";
        $maxquality = $this->getMaxQuality();

        $command = "$executable --max=$maxquality $stripAll $allProgressive ".escapeshellarg($image);
        exec($command, $output, $status);

        if ($status>0) {
            throw new Exception(
                "Jpegoptim compression failed with the following command : "
                . "'$command'. Is jpegoptim installed and runnable ?"
            );
        }
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
