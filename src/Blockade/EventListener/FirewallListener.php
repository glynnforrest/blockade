<?php

namespace Blockade\EventListener;

use Blockade\Firewall;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * FirewallListener listens for Requests and validates them against a
 * collection of Firewalls.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class FirewallListener implements EventSubscriberInterface
{

    protected $firewalls = array();

    /**
     * Add a Firewall instance to this listener.
     *
     * @param Firewall $firewall the firewall to add
     */
    public function addFirewall(Firewall $firewall)
    {
        $this->firewalls[] = $firewall;

        return $this;
    }

    /**
     * Add a Firewall instance to this listener, pushing it to the
     * front so it is checked first.
     *
     * @param Firewall $firewall the firewall to add
     */
    public function pushFirewall(Firewall $firewall)
    {
        array_unshift($this->firewalls, $firewall);

        return $this;
    }

    /**
     * Get all registered firewalls in an array.
     *
     * @return array An array of registered firewalls.
     */
    public function getFirewalls()
    {
        return $this->firewalls;
    }

    /**
     * Respond to a REQUEST KernelEvent by validating the request
     * against the registered firewalls.
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        foreach ($this->firewalls as $firewall) {
            if ($firewall->check($request)) {
                return true;
            }
        }

        return true;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('onKernelRequest')
        );
    }

}
