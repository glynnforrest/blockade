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
    protected $message = 'Authentication required';
    protected $code = 401;
}
