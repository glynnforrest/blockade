<?php

namespace Blockade\Exception;

use Blockade\Driver\SecurityDriverInterface;

/**
 * CredentialsException is thrown when authentication fails due to
 * incomplete or incorrect credentials.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class CredentialsException extends BlockadeException
{

    public function __construct(SecurityDriverInterface $driver, $message = 'Bad credentials supplied', \Exception $previous = null)
    {
        parent::__construct($driver, $message, 401, $previous);
    }

}
