<?php

namespace Blockade\Exception;

use Blockade\Driver\DriverInterface;

use Symfony\Component\HttpFoundation\Request;

/**
 * BlockadeException
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
abstract class BlockadeException extends \Exception
{

    protected $driver;

    public function __construct(DriverInterface $driver, $message = '', $code = 403, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->driver = $driver;
    }

    public function setDriver(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function getDriver()
    {
        return $this->driver;
    }

}
