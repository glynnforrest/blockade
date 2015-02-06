<?php

namespace Blockade\User;

/**
 * UserInterface
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
interface UserInterface
{
    /**
     * Get the identifier used to log in.
     *
     * @return string The identifier
     */
    public function getIdentifier();

    /**
     * Get the identifier to display to humans. This may be the same
     * as the result of getIdentifier().
     *
     * @return string The identifier
     */
    public function getHumanIdentifier();
}
