<?php

namespace Blockade\Exception;

use Blockade\Driver\DriverInterface;

/**
 * SessionException is thrown when the session is invalid or has
 * expired.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class SessionException extends BlockadeException
{

    public function __construct(DriverInterface $driver, $message = 'Session is invalid', \Exception $previous = null)
    {
        parent::__construct($driver, $message, 403, $previous);
    }

}
