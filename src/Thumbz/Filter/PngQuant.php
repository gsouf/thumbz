<?php

namespace Thumbz\Filter;

use Imagine\Image\ImageInterface;
use Thumbz\Exception;

class PngQuant implements FileFilterInterface
{

    protected $executable = "pngquant";
    protected $minQuality = 80;
    protected $maxQuality = 100;

    /**
     * PngQuant constructor.
     * @param int $minQuality
     * @param int $maxQuality
     */
    public function __construct($minQuality = 60, $maxQuality = 80)
    {
        $this->minQuality = $minQuality;
        $this->maxQuality = $maxQuality;
    }


    public function filter($image)
    {


        $executable = $this->getExecutable();
        $minquality = $this->getMinQuality();
        $maxquality = $this->getMaxQuality();

        $filePath = escapeshellarg($image);

        $command = "$executable --quality=$minquality-$maxquality -f -o $filePath -- $filePath";
        exec($command, $return, $status);



        // 0 = ok
        // 99 = ok, but no compression because quality was already to high
        if ($status != 0 && $status != 99) {
            throw new Exception(
                "Pngquant compression failed with the following command : "
                ."'$command'. Is pngquant 1.8+ installed on the server ? "
            );
        }


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
     * @return int
     */
    public function getMinQuality()
    {
        return $this->minQuality;
    }

    /**
     * @param int $minQuality
     */
    public function setMinQuality($minQuality)
    {
        $this->minQuality = $minQuality;
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
