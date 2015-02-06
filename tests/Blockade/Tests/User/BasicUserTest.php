<?php

namespace Blockade\Tests\User;

use Blockade\User\BasicUser;

/**
 * BasicUserTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class BasicUserTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->user = new BasicUser('admin', 'Admin User');
    }

    public function testUser()
    {
        $this->assertInstanceOf('Blockade\User\UserInterface', $this->user);
    }

    public function testGetIdentifier()
    {
        $this->assertSame('admin', $this->user->getIdentifier());
    }

    public function testGetHumanIdentifier()
    {
        $this->assertSame('Admin User', $this->user->getHumanIdentifier());
    }
}
