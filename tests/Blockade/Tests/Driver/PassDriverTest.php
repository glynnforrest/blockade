<?php

namespace Blockade\Tests\Driver;

use Blockade\Driver\PassDriver;

/**
 * PassDriverTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class PassDriverTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->driver = new PassDriver();
    }

    public function testInheritance()
    {
        $this->assertInstanceOf('\Blockade\Driver\DriverInterface', $this->driver);
        $this->assertInstanceOf('\Blockade\Driver\AbstractDriver', $this->driver);
    }

    public function testAuthenticate()
    {
        $this->assertTrue($this->driver->authenticate());
    }

    public function testLogin()
    {
        $this->assertTrue($this->driver->login('username'));
    }

    public function testLogout()
    {
        $this->assertTrue($this->driver->logout());
    }

    public function testIsAuthenticated()
    {
        $this->assertTrue($this->driver->isAuthenticated());
    }

    public function testHasPermission()
    {
        $this->assertTrue($this->driver->hasPermission('ANY'));
    }

}