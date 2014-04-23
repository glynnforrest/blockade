<?php

namespace Blockade\Exception;

use Blockade\Driver\DriverInterface;

/**
 * CsrfTokenException is thrown when the client supplies an incorrect
 * csrf token, or fails to supply one at all.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class CsrfTokenException extends BlockadeException
{

    public function __construct(DriverInterface $driver, $message = 'Invalid csrf token supplied', \Exception $previous = null)
    {
        parent::__construct($driver, $message, 403, $previous);
    }

}
