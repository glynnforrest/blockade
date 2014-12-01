<?php

namespace Blockade\Tests\Exception;

/**
 * BlockadeExceptionTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class BlockadeExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAndSetDriver()
    {
        $ex = $this->getMockForAbstractClass('Blockade\Exception\BlockadeException');
        $driver = $this->getMock('Blockade\Driver\DriverInterface');
        $this->assertNull($ex->getDriver());
        $ex->setDriver($driver);
        $this->assertSame($driver, $ex->getDriver());
    }

    public function messageAndCodesProvider()
    {
        return array(
            array('Anonymous', 'Access denied', 403),
            array('Authentication', 'Authentication required', 401),
            array('Authorization', 'Access denied', 403),
            array('Credentials', 'Bad credentials supplied', 401),
            array('Session', 'Session is invalid', 403),
        );
    }

    /**
     * @dataProvider messageAndCodesProvider()
     */
    public function testFrom($type, $message, $code)
    {
        $class = 'Blockade\Exception\\'.$type.'Exception';
        $driver = $this->getMock('Blockade\Driver\DriverInterface');

        $ex = $class::from($driver);
        $this->assertInstanceOf($class, $ex);
        $this->assertInstanceOf('Blockade\Exception\BlockadeException', $ex);

        $this->assertSame($message, $ex->getMessage());
        $this->assertSame($code, $ex->getCode());
    }

    /**
     * @dataProvider messageAndCodesProvider()
     */
    public function testFromWithMessage($type, $message, $code)
    {
        $class = 'Blockade\Exception\\'.$type.'Exception';
        $driver = $this->getMock('Blockade\Driver\DriverInterface');

        $ex = $class::from($driver, 'foo');
        $this->assertInstanceOf($class, $ex);
        $this->assertInstanceOf('Blockade\Exception\BlockadeException', $ex);

        $this->assertSame('foo', $ex->getMessage());
        $this->assertSame($code, $ex->getCode());
    }

    /**
     * @dataProvider messageAndCodesProvider()
     */
    public function testFromWithMessageAndCode($type, $message, $code)
    {
        $class = 'Blockade\Exception\\'.$type.'Exception';
        $driver = $this->getMock('Blockade\Driver\DriverInterface');

        $ex = $class::from($driver, 'foo', 10);
        $this->assertInstanceOf($class, $ex);
        $this->assertInstanceOf('Blockade\Exception\BlockadeException', $ex);

        $this->assertSame('foo', $ex->getMessage());
        $this->assertSame(10, $ex->getCode());
    }
}
