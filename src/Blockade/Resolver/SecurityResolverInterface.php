<?php

namespace Blockade\Resolver;

use Blockade\Exception\BlockadeException;

use Symfony\Component\HttpFoundation\Request;

/**
 * SecurityResolverInterface
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
interface SecurityResolverInterface
{

    public function onException(BlockadeException $exception, Request $request);

    public function getSupportedExceptions();

    public function getSupportedDrivers();

}
