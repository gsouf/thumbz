<?php
/**
 * @license see LICENSE
 */

namespace Thumbz\Test;


use Thumbz\PathProtectorTrait;

class PathProtectorMock
{

    use PathProtectorTrait;

    public function __construct($dir)
    {
        $this->pathProtectorSetBase($dir);
    }

}