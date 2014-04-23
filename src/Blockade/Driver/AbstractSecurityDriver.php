<?php

namespace Blockade\Driver;

use Blockade\Driver\SecurityDriverInterface;
use Blockade\Exception\BlockadeFailureException;

use Symfony\Component\HttpFoundation\Request;

/**
 * AbstractSecurityDriver
 * @author Glynn Forrest me@glynnforrest.com
 **/
abstract class AbstractSecurityDriver implements SecurityDriverInterface
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
