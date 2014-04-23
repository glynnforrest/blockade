<?php

namespace Blockade\Exception;

use Blockade\Driver\DriverInterface;

/**
 * AuthenticationException is thrown when authentication is required.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class AuthenticationException extends BlockadeException
{

    public function __construct(DriverInterface $driver, $message = 'Authentication required', \Exception $previous = null)
    {
        parent::__construct($driver, $message, 401, $previous);
    }

}
