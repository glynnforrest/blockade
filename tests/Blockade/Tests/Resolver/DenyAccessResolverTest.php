<?php

namespace Blockade\Tests\Resolver;

use Blockade\Resolver\DenyAccessResolver;

/**
 * DenyAccessResolverTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class DenyAccessResolverTest extends ResolverTestCase
{
    public function setUp()
    {
        $this->resolver = new DenyAccessResolver();
    }
}
