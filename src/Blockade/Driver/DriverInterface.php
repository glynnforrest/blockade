<?php

namespace Blockade\Driver;

use Symfony\Component\HttpFoundation\Request;

/**
 * DriverInterface
 * @author Glynn Forrest me@glynnforrest.com
 **/
interface DriverInterface
{

    public function setRequest(Request $request);

    public function getRequest();

    public function hasRequest();

    public function authenticate();

    public function login($identifier);

    public function logout();

    public function isAuthenticated();

    public function hasPermission($permission);

}
