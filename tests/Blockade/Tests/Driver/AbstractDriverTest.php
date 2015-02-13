<?php

namespace Blockade\Tests\Driver;

/**
 * AbstractDriverTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class AbstractDriverTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->driver = $this->getMockForAbstractClass('Blockade\Driver\AbstractDriver');
    }

    public function testSetAndGetRequest()
    {
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $this->assertSame($this->driver, $this->driver->setRequest($request));
        $this->assertSame($request, $this->driver->getRequest());
    }

    public function testHasRequest()
    {
        $this->assertFalse($this->driver->hasRequest());
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $this->assertSame($this->driver, $this->driver->setRequest($request));
        $this->assertTrue($this->driver->hasRequest());
    }

}
