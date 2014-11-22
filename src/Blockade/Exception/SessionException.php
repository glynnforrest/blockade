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
    protected $message = 'Session is invalid';
    protected $code = 403;
}
