<?php

namespace Blockade\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

use Blockade\Driver\DriverInterface;

/**
 * RequestListener sets the current Request to a Driver.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class RequestListener implements EventSubscriberInterface
{

    protected $drivers = array();

    /**
     * Add a driver. It will be given the request on a kernel request
     * event.
     *
     * @param  DriverInterface $driver The driver
     * @return RequestListener This listener instance
     */
    public function addDriver(DriverInterface $driver)
    {
        $this->drivers[] = $driver;

        return $this;
    }

    /**
     * Get all drivers.
     *
     * @return array An array of drivers
     */
    public function getDrivers()
    {
        return $this->drivers;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        foreach ($this->drivers as $driver) {
            if (!$driver->hasRequest()) {
                $driver->setRequest($request);
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
