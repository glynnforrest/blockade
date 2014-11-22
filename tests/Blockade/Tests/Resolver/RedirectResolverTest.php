<?php

namespace Blockade\Tests\Resolver;

use Blockade\Resolver\RedirectResolver;

/**
 * RedirectResolverTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class RedirectResolverTest extends ResolverTestCase
{
    public function setUp()
    {
        $this->resolver = new RedirectResolver();
    }
}
