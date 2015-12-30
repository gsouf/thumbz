<?php
/**
 * @license see LICENSE
 */

namespace Thumbz\Filter;

use Thumbz\Exception;

class Cwebp extends AbstractFilter
{

    protected $executable = "cwebp";
    protected $alphaQuality;
    protected $filteringStrength;

    /**
     * PngQuant constructor.
     * @param int $minQuality
     * @param int $maxQuality
     */
    public function __construct($quality = 80, $alphaQuality = 80)
    {
        $this->quality = $quality;
        $this->alphaQuality = $alphaQuality;
    }

    public function filter($image)
    {

        $path = escapeshellarg($image);
        exec("$this->executable -q $this->quality -alpha_q $this->alphaQuality -quiet -o $path -- $path", $r, $exit);

        if ($exit > 0) {
            throw new Exception("Unable to save image in webp format");
        }

    }
}
