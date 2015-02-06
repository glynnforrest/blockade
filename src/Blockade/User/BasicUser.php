<?php

namespace Blockade\User;

/**
 * BasicUser
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class BasicUser implements UserInterface
{
    protected $identifier;
    protected $human;

    public function __construct($identifier, $human)
    {
        $this->identifier = $identifier;
        $this->human = $human;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getHumanIdentifier()
    {
        return $this->human;
    }
}
