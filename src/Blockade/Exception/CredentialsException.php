<?php

namespace Blockade\Exception;

use Blockade\Driver\DriverInterface;

/**
 * CredentialsException is thrown when authentication fails due to
 * incomplete or incorrect credentials.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class CredentialsException extends BlockadeException
{
    protected $message = 'Bad credentials supplied';
    protected $code = 401;
}
