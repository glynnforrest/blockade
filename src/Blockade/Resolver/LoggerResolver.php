<?php

namespace Blockade\Resolver;

use Blockade\Driver\DriverInterface;
use Blockade\Exception\BlockadeException;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * LoggerResolver logs all security exceptions before passing them on.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class LoggerResolver implements ResolverInterface
{
    protected $logger;
    protected $level;

    public function __construct(LoggerInterface $logger, $level = LogLevel::INFO)
    {
        $this->logger = $logger;
        $this->level = $level;
    }

    public function onException(BlockadeException $exception, Request $request)
    {
        $driver = $exception->getDriver();
        $msg = $driver ? get_class($driver).' threw ' : '';
        $msg .= sprintf('%s with message "%s" from ip %s on page %s',
            get_class($exception),
            $exception->getMessage(),
            $request->getClientIp(),
            $request->getUri()
        );

        $this->logger->log($this->level, $msg);
    }

    public function supportsDriver(DriverInterface $driver)
    {
        return true;
    }

    public function supportsException(BlockadeException $exception)
    {
        return true;
    }

}
