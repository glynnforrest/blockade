<?php

namespace Blockade\Resolver;

use Blockade\Exception\BlockadeException;
use Blockade\Driver\DriverInterface;

use Symfony\Component\HttpFoundation\Request;

/**
 * ResolverInterface
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
interface ResolverInterface
{

    public function onException(BlockadeException $exception, Request $request);

    public function supportsDriver(DriverInterface $driver);

    public function supportsException(BlockadeException $exception);

}
