<?php

namespace Blockade\Resolver;

use Blockade\Driver\DriverInterface;
use Blockade\Exception\BlockadeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * DenyAccessResolver returns a response with the exception message and status
 * code.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class DenyAccessResolver implements ResolverInterface
{
    public function onException(BlockadeException $exception, Request $request)
    {
        return new Response($this->message, 403);
    }

    public function supportsDriver(DriverInterface $driver)
    {
        return true;
    }

    public function supportsException(BlockadeException $exception)
    {
        return true;
    }
}
