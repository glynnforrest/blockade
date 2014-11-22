<?php

namespace Blockade\Exception;

use Blockade\Driver\DriverInterface;

/**
 * AuthorizationException is thrown when the client does not have permission
 * to access a resource.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class AuthorizationException extends BlockadeException
{
    protected $message = 'Access denied';
    protected $code = 403;
}
