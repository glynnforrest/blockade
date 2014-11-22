<?php

namespace Blockade\Tests\Resolver;

use Blockade\Resolver\LoggerResolver;
use Blockade\Driver\FailDriver;
use Blockade\Exception\AuthorizationException;
use Psr\Log\LogLevel;

/**
 * LoggerResolverTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class LoggerResolverTest extends ResolverTestCase
{
    public function setUp()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');
        $this->resolver = new LoggerResolver($this->logger, LogLevel::NOTICE);
    }

    public function testOnException()
    {
        $driver = new FailDriver();
        $exception = AuthorizationException::from($driver);

        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $request->expects($this->any())
                ->method('getUri')
                ->will($this->returnValue('/foo'));
        $request->expects($this->any())
                ->method('getClientIp')
                ->will($this->returnValue('127.0.0.1'));

        $msg = 'Blockade\Driver\FailDriver threw Blockade\Exception\AuthorizationException with message "Access denied" from ip 127.0.0.1 on page /foo';
        $this->logger->expects($this->once())
                     ->method('log')
                     ->with(LogLevel::NOTICE, $msg);

        $this->resolver->onException($exception, $request);
    }

    public function testOnExceptionNoDriver()
    {
        $exception = new AuthorizationException();

        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');
        $request->expects($this->any())
                ->method('getUri')
                ->will($this->returnValue('/foo'));
        $request->expects($this->any())
                ->method('getClientIp')
                ->will($this->returnValue('127.0.0.1'));

        $msg = 'Blockade\Exception\AuthorizationException with message "Access denied" from ip 127.0.0.1 on page /foo';
        $this->logger->expects($this->once())
                     ->method('log')
                     ->with(LogLevel::NOTICE, $msg);

        $this->resolver->onException($exception, $request);
    }
}
