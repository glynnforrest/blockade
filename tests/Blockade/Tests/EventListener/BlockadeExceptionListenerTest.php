<?php

namespace Blockade\Tests\EventListener;

use Blockade\EventListener\BlockadeExceptionListener;
use Blockade\Exception\AuthorizationException;
use Blockade\Driver\FailDriver;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

require_once __DIR__ . '/../../../bootstrap.php';

/**
 * BlockadeExceptionListenerTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class BlockadeExceptionListenerTest extends \PHPUnit_Framework_TestCase
{

    protected $firewall;

    public function setUp()
    {
        $this->listener = new BlockadeExceptionListener();
    }

    protected function newResolver()
    {
        return $this->getMock('Blockade\Resolver\ResolverInterface');
    }

    public function testAddResolver()
    {
        $this->assertSame(array(), $this->listener->getResolvers());
        $firewall = $this->newResolver();
        $this->listener->addResolver($firewall);
        $this->assertSame(array($firewall), $this->listener->getResolvers());
        $this->listener->addResolver($firewall);
        $this->assertSame(array($firewall, $firewall), $this->listener->getResolvers());
    }

    public function testPushResolver()
    {
        $this->assertSame(array(), $this->listener->getResolvers());

        $first = $this->newResolver();
        $this->listener->addResolver($first);
        $this->assertSame(array($first), $this->listener->getResolvers());

        $second = $this->newResolver();
        $this->listener->pushResolver($second);
        $this->assertSame(array($second, $first), $this->listener->getResolvers());

        $third = $this->newResolver();
        $this->listener->addResolver($third);
        $this->assertSame(array($second, $first, $third), $this->listener->getResolvers());

        $fourth = $this->newResolver();
        $this->listener->pushResolver($fourth);
        $this->assertSame(array($fourth, $second, $first, $third), $this->listener->getResolvers());
    }

    public function testGetSubscribedEvents()
    {
        $expected = array(KernelEvents::EXCEPTION => array('onKernelException'));
        $this->assertSame($expected, BlockadeExceptionListener::getSubscribedEvents());
    }

    public function testOnKernelException()
    {
        $driver = new FailDriver();
        $exception = new AuthorizationException($driver);
        $request = new Request();
        $response = new Response();

        $resolver = $this->newResolver();
        $this->listener->addResolver($resolver);
        $resolver->expects($this->once())
                 ->method('getSupportedExceptions')
                 ->will($this->returnValue(true));
        $resolver->expects($this->once())
                 ->method('getSupportedDrivers')
                 ->will($this->returnValue(true));
        $resolver->expects($this->once())
                 ->method('onException')
                 ->with($exception, $request)
                 ->will($this->returnValue($response));

        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')
                      ->disableOriginalConstructor()
                      ->getMock();
        $event = new GetResponseForExceptionEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST, $exception);

        $this->assertFalse($event->hasResponse());
        $this->listener->onKernelException($event);
        $this->assertTrue($event->hasResponse());
    }

}
