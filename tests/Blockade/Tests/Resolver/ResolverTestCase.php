<?php

namespace Blockade\Tests\Resolver;

/**
 * ResolverTestCase
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
abstract class ResolverTestCase extends \PHPUnit_Framework_TestCase
{
    protected $resolver;

    public function testSupportsDriver()
    {
        $driver = $this->getMock('Blockade\Driver\DriverInterface');
        $this->assertTrue($this->resolver->supportsDriver($driver));
    }

    public function testSupportsException()
    {
        $exception = $this->getMock('Blockade\Exception\BlockadeException');
        $this->assertTrue($this->resolver->supportsException($exception));
    }
}
