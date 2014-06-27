<?php

namespace Blockade\Tests\EventListener;

use Blockade\EventListener\RequestListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../../../bootstrap.php';

/**
 * RequestListenerTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class RequestListenerTest extends \PHPUnit_Framework_TestCase
{

    protected $listener;

    public function setUp()
    {
        $this->listener = new RequestListener();
    }

    public function testGetSubscribedEvents()
    {
        $expected = array(KernelEvents::REQUEST => array('onKernelRequest'));
        $this->assertSame($expected, RequestListener::getSubscribedEvents());
    }

    public function testAddAndGetDrivers()
    {
        $this->assertSame(array(), $this->listener->getDrivers());
        $driver = $this->getMock('Blockade\Driver\DriverInterface');
        $this->assertSame($this->listener, $this->listener->addDriver($driver));
        $this->assertSame(array($driver), $this->listener->getDrivers());
        $this->assertSame($this->listener, $this->listener->addDriver($driver));
        $this->assertSame(array($driver, $driver), $this->listener->getDrivers());
    }

    public function testOnKernelRequest()
    {
        $request = new Request();
        $event = $this->getMockBuilder('Symfony\Component\HttpKernel\Event\GetResponseEvent')
                      ->disableOriginalConstructor()
                      ->getMock();

        $event->expects($this->once())
              ->method('getRequest')
              ->will($this->returnValue($request));

        $driver = $this->getMock('Blockade\Driver\DriverInterface');
        $this->listener->addDriver($driver)
                       ->addDriver($driver);

        $driver->expects($this->exactly(2))
                      ->method('setRequest')
                      ->with($request);

        $this->listener->onKernelRequest($event);
    }

    public function testOnKernelRequestWithRequestAlready()
    {
        $request = new Request();
        $event = $this->getMockBuilder('Symfony\Component\HttpKernel\Event\GetResponseEvent')
                      ->disableOriginalConstructor()
                      ->getMock();

        $event->expects($this->once())
              ->method('getRequest')
              ->will($this->returnValue($request));

        $driver = $this->getMock('Blockade\Driver\DriverInterface');
        $driver->expects($this->once())
               ->method('hasRequest')
               ->will($this->returnValue(true));

        $this->listener->addDriver($driver);

        $driver->expects($this->never())
               ->method('setRequest');

        $this->listener->onKernelRequest($event);
    }

}
