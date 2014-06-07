<?php

namespace Blockade\Driver;

use Blockade\Driver\DriverInterface;
use Blockade\Exception\BlockadeFailureException;

use Symfony\Component\HttpFoundation\Request;

/**
 * AbstractDriver
 * @author Glynn Forrest me@glynnforrest.com
 **/
abstract class AbstractDriver implements DriverInterface
{

    protected $request;

    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function hasRequest()
    {
        return $this->request ? true : false;
    }

    protected function getSession()
    {
        if (!$this->request) {
            throw new BlockadeFailureException("No Request defined");
        }
        if (!$this->request->hasSession()) {
            throw new BlockadeFailureException("No Session defined");
        }
        //check for invalid session
        return $this->request->getSession();
    }

}
