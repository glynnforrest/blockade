<?php

namespace Blockade\Tests\EventListener;

use Blockade\EventListener\FirewallListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../../../bootstrap.php';

/**
 * FirewallListenerTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class FirewallListenerTest extends \PHPUnit_Framework_TestCase
{

    protected $firewall;

    public function setUp()
    {
        $this->listener = new FirewallListener();
    }

    protected function newFirewall()
    {
        return $this->getMockBuilder('Blockade\Firewall')
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    public function testAddFirewall()
    {
        $this->assertSame(array(), $this->listener->getFirewalls());
        $firewall = $this->newFirewall();
        $this->listener->addFirewall($firewall);
        $this->assertSame(array($firewall), $this->listener->getFirewalls());
        $this->listener->addFirewall($firewall);
        $this->assertSame(array($firewall, $firewall), $this->listener->getFirewalls());
    }

    public function testPushFirewall()
    {
        $this->assertSame(array(), $this->listener->getFirewalls());

        $first = $this->newFirewall();
        $this->listener->addFirewall($first);
        $this->assertSame(array($first), $this->listener->getFirewalls());

        $second = $this->newFirewall();
        $this->listener->pushFirewall($second);
        $this->assertSame(array($second, $first), $this->listener->getFirewalls());

        $third = $this->newFirewall();
        $this->listener->addFirewall($third);
        $this->assertSame(array($second, $first, $third), $this->listener->getFirewalls());

        $fourth = $this->newFirewall();
        $this->listener->pushFirewall($fourth);
        $this->assertSame(array($fourth, $second, $first, $third), $this->listener->getFirewalls());
    }

    public function testGetSubscribedEvents()
    {
        $expected = array(KernelEvents::REQUEST => array('onKernelRequest'));
        $this->assertSame($expected, FirewallListener::getSubscribedEvents());
    }

    protected function newEvent(Request $request)
    {
        $event = $this->getMockBuilder('Symfony\Component\HttpKernel\Event\GetResponseEvent')
                      ->disableOriginalConstructor()
                      ->getMock();
        $event->expects($this->once())
              ->method('getRequest')
              ->with()
              ->will($this->returnValue($request));
        return $event;
    }

    public function testTwoFirewallsFail()
    {
        $request = new Request();

        $first = $this->newFirewall();
        $this->listener->addFirewall($first);
        $first->expects($this->once())
              ->method('check')
              ->with($request)
              ->will($this->returnValue(false));

        //the first firewall didn't pass, so the second is called
        $second = $this->newFirewall();
        $this->listener->addFirewall($second);
        $second->expects($this->once())
               ->method('check')
               ->with($request)
               ->will($this->returnValue(false));

        $event = $this->newEvent($request);
        $this->listener->onKernelRequest($event);
    }

    public function testFirstFirewallPasses()
    {
        $request = new Request();

        $first = $this->newFirewall();
        $this->listener->addFirewall($first);
        $first->expects($this->once())
              ->method('check')
              ->with($request)
              ->will($this->returnValue(true));

        //the first firewall passed, so the second is not called
        $second = $this->newFirewall();
        $this->listener->addFirewall($second);
        $second->expects($this->never())
               ->method('check');

        $event = $this->newEvent($request);
        $this->listener->onKernelRequest($event);
    }

}
