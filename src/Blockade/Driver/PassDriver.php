<?php

namespace Blockade\Driver;

use Blockade\Driver\AbstractDriver;
use Blockade\User\BasicUser;

/**
 * PassDriver
 * @author Glynn Forrest me@glynnforrest.com
 **/
class PassDriver extends AbstractDriver
{

    public function authenticate()
    {
        return true;
    }

    public function login($identifier)
    {
        return true;
    }

    public function logout()
    {
        return true;
    }

    public function isAuthenticated()
    {
        return true;
    }

    public function hasPermission($permission)
    {
        return true;
    }

    public function getUser()
    {
        return new BasicUser('admin', 'Admin User');
    }
}
