<?php

namespace Blockade\Resolver;

use Blockade\Exception\SecurityException;

use Symfony\Component\HttpFoundation\Request;

/**
 * SecurityResolverInterface
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
interface SecurityResolverInterface
{

    public function onException(SecurityException $exception, Request $request);

    public function getSupportedExceptions();

    public function getSupportedDrivers();

}
