<?php

namespace Blockade\EventListener;

use Blockade\Resolver\ResolverInterface;
use Blockade\Driver\DriverInterface;
use Blockade\Driver\CsrfDriver;
use Blockade\Exception\BlockadeException;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Response;

/**
 * BlockadeExceptionListener handles any BlockadeExceptions and
 * attempts to return a Response by using its registered Resolvers.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class BlockadeExceptionListener implements EventSubscriberInterface
{

    protected $resolvers = array();

    public function addResolver(ResolverInterface $resolver)
    {
        $this->resolvers[] = $resolver;
    }

    public function pushResolver(ResolverInterface $resolver)
    {
        array_unshift($this->resolvers, $resolver);
    }

    public function getResolvers()
    {
        return $this->resolvers;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if (!$exception instanceof BlockadeException) {
            return;
        }
        //try to get a response from one of the resolvers. It
        //could be a redirect, an access denied page, or anything
        //really
        try {
            foreach ($this->resolvers as $resolver) {
                if (!$this->resolverSupportsException($resolver, $exception)) {
                    continue;
                }

                if (!$this->resolverSupportsDriver($resolver, $exception->getDriver())) {
                    continue;
                }

                $request = $event->getRequest();
                $response = $resolver->onException($exception, $request);
                if ($response instanceof Response) {
                    $event->setResponse($response);

                    return true;
                }
            }
            //no response has been created by now, so let other
            //exception listeners handle it
            return;
        } catch (\Exception $e) {
            //if anything at all goes wrong in calling the
            //resolvers, pass the exception on
            echo $e->getMessage();
            $event->setException($e);
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => array('onKernelException')
        );
    }

    public function resolverSupportsException(ResolverInterface $resolver, BlockadeException $exception)
    {
        $supported = $resolver->getSupportedExceptions();

        if (true === $supported) {
            return true;
        }
        if (!is_array($supported)) {
            return false;
        }
        if (in_array(get_class($exception), $supported)) {
            return true;
        }

        return false;
    }

    public function resolverSupportsDriver(ResolverInterface $resolver, DriverInterface $driver)
    {
        //If the exception comes from the CsrfDriver, imply
        //support. Support for csrf can be disabled by not including
        //CsrfException in getSupportedExceptions.
        if ($driver instanceof CsrfDriver) {
            return true;
        }

        $supported = $resolver->getSupportedDrivers();

        if (true === $supported) {
            return true;
        }

        if (!is_array($supported)) {
            return false;
        }
        if (in_array(get_class($driver), $supported)) {
            return true;
        }

        return false;
    }

}