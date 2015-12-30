<?php

namespace Thumbz\Test;

/**
 * @license see LICENSE
 */
use Thumbz\Exception\RootPathViolationException;
use Thumbz\PathProtectorTrait;

/**
 * @covers Thumbz\PathProtectorTrait
 */
class PathProtectorTraitTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PathProtectorTrait
     */
    protected $pathProtector;

    public function setUp()
    {
        $this->pathProtector = new PathProtectorMock("/root/protected");
    }

    public function testGetBase()
    {
        $this->assertEquals("/root/protected/", $this->pathProtector->pathProtectorGetBase());
    }


    public function testPathProtectorProtect()
    {

        $this->assertEquals("/root/protected/foo", $this->pathProtector->pathProtectorProtect("foo"));
        $this->assertEquals("/root/protected/foo/bar", $this->pathProtector->pathProtectorProtect("foo/bar"));
        $this->assertEquals("/root/protected/foo", $this->pathProtector->pathProtectorProtect("foo/../foo"));
        $this->assertEquals("/root/protected/bar", $this->pathProtector->pathProtectorProtect("foo/../bar"));
        $this->assertEquals("/root/protected/foo", $this->pathProtector->pathProtectorProtect("foo/."));
        $this->assertEquals("/root/protected/foo/bar", $this->pathProtector->pathProtectorProtect("./foo/bar/../bar"));
        $this->assertEquals("/root/protected/foo/bar", $this->pathProtector->pathProtectorProtect("../protected/foo/bar"));
        $this->assertEquals("/root/protected/foo/bar", $this->pathProtector->pathProtectorProtect("/root/protected/foo/bar"));
        $this->assertEquals("/root/protected/foo/bar", $this->pathProtector->pathProtectorProtect("/root/../root/protected/foo/bar"));


        try {
            $this->pathProtector->pathProtectorProtect("foo/../../bar");
            $this->fail("Exception not thrown");
        } catch (RootPathViolationException $e) {
            $this->assertTrue(true);
        }

        try {
            $this->pathProtector->pathProtectorProtect("../foo/bar");
            $this->fail("Exception not thrown");
        } catch (RootPathViolationException $e) {
            $this->assertTrue(true);
        }


    }
}
