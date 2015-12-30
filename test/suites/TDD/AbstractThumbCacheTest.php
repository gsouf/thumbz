<?php

namespace Thumbz\Test;

use Thumbz\AbstractThumbCache;

/**
 * @covers Thumbz\AbstractThumbCache
 */
class AbstractThumbCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractThumbCache
     */
    protected $thumbCache;

    public function setUp()
    {
        $this->thumbCache = $this->getMockForAbstractClass(AbstractThumbCache::class);
    }

    public function testGetCacheName(){
        $this->assertEquals("foo.5-10.png", $this->thumbCache->getCacheName("foo", 5, 10, "png"));
        $this->assertEquals("foo.5-10.jpg", $this->thumbCache->getCacheName("foo", 5, 10, "jpg"));
    }


}
