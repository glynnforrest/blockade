<?php

namespace Blockade\Resolver;

use Blockade\Exception\BlockadeException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * DenyAccessResolver is a simple resolver that responds with a 403
 * (forbidden) Response
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class DenyAccessResolver implements ResolverInterface
{
    protected $message;

    public function __construct($message = 'You do not have permission to access this resource.')
    {
        $this->message = $message;
    }

    public function onException(BlockadeException $exception, Request $request)
    {
        return new Response($this->message, 403);
    }

    public function getSupportedExceptions()
    {
        return true;
    }

    public function getSupportedDrivers()
    {
        return true;
    }

}
