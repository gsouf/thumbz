<?php

namespace Thumbz\Filter;

use Imagine\Image\ImageInterface;
use Thumbz\Exception;

class PngQuant extends AbstractFilter {

    protected $executable = "pngquant";
    protected $minQuality = 80;
    protected $maxQuality = 100;

    protected function _filter(ImageInterface $image)
    {
        $tempFile = tempnam("/tmp", "thumbz_quant");
        $image->save($tempFile, ["quality"=>100, "format" => "png"]);

        $executable = $this->getExecutable();
        $minquality = $this->getMinQuality();
        $maxquality = $this->getMaxQuality();

        $command = "$executable --quality=$minquality-$maxquality - < ".escapeshellarg($tempFile);
        $compressed = shell_exec($command);

        if (!$compressed) {
            throw new Exception("Pngquant compression failed with the following command : '$command'. Is pngquant 1.8+ installed on the server ? ");
        }

        unlink($tempFile);
        return $this->getImagineAdapter()->load($compressed);

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