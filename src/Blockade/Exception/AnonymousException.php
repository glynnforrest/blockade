<?php

namespace Blockade\Exception;

use Blockade\Driver\DriverInterface;

/**
 * AnonymousException is thrown when the client does not have
 * permission to access a resource, even with authentication.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class AnonymousException extends BlockadeException
{

    public function __construct(DriverInterface $driver, $message = 'Access denied', \Exception $previous = null)
    {
        parent::__construct($driver, $message, 403, $previous);
    }

}
