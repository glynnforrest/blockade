<?php

namespace Blockade\Exception;

use Blockade\Driver\DriverInterface;

/**
 * AnonymousException is thrown when the client is required to be anonymous
 * but is authenticated.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class AnonymousException extends BlockadeException
{
    protected $message = 'Access denied';
    protected $code = 403;
}
