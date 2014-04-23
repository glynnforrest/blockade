<?php

namespace Blockade\Resolver;

use Blockade\Exception\BlockadeException;

use Symfony\Component\HttpFoundation\Request;

/**
 * ResolverInterface
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
interface ResolverInterface
{

    public function onException(BlockadeException $exception, Request $request);

    public function getSupportedExceptions();

    public function getSupportedDrivers();

}
