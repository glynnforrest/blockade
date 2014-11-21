<?php

namespace Blockade\Exception;

use Blockade\Driver\DriverInterface;

/**
 * BlockadeException
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
abstract class BlockadeException extends \Exception
{
    protected $driver;

    /**
     * Factory method to set the driver that created this exception.
     *
     * @param DriverInterface $driver The driver
     */
    public static function from(DriverInterface $driver, $message = '', $code = 403, \Exception $previous = null)
    {
        $self = new static($message, $code, $previous);
        $self->setDriver($driver);

        return $self;
    }

    /**
     * Set the driver that created this exception. This can be used by
     * resolvers to determine how to handle a violation.
     *
     * @param DriverInterface $driver The driver
     */
    public function setDriver(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Get the driver that created this exception. This is optional - no
     * driver may be set.
     *
     * @return DriverInterface | null The driver or null
     */
    public function getDriver()
    {
        return $this->driver;
    }
}
