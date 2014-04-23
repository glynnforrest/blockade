<?php

namespace Blockade\Tests\Csrf;

require_once __DIR__ . '/../../bootstrap.php';

use Blockade\CsrfManager;
use Blockade\Exception\CsrfTokenException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

/**
 * CsrfManagerTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class CsrfManagerTest extends \PHPUnit_Framework_TestCase
{

    protected $manager;
    protected $driver;
    protected $session;

    public function setUp()
    {
        $this->session = new Session(new MockArraySessionStorage());
        $this->manager = new CsrfManager($this->session);
    }

    protected function setSessionToken($name, $token)
    {
        $this->session->set('blockade.csrf.' . $name, $token);
    }

    public function checkProvider()
    {
        return array(
            array('secret_token', 'secret_token', true),
            array('secret_token', 'secret_oken'),
            array(null, 'secret_token'),
            array('secret_token', null),
            array(null, null),
        );
    }

    /**
     * @dataProvider checkProvider()
     */
    public function testCheck($token, $session_token, $pass = false)
    {
        $this->setSessionToken('testing', $session_token);
        if ($pass) {
            $this->assertTrue($this->manager->check('testing', $token));
        } else {
            $this->setExpectedException('\Blockade\Exception\CsrfTokenException');
            $this->manager->check('testing', $token);
        }
    }

    public function testTokenIsExpiredAfterSuccess()
    {
        $this->setSessionToken('testing', 'secret');
        $this->assertTrue($this->manager->check('testing', 'secret'));
        //token should have now expired
        $this->setExpectedException('\Blockade\Exception\CsrfTokenException');
        $this->manager->check('testing', 'secret');
    }

    public function testTokenIsNotExpiredOnFailure()
    {
        $this->setSessionToken('testing', 'valid_token');

        //catch the exception so we can use assertions in this method
        try {
            $this->manager->check('testing', 'invalid_token');
        } catch (CsrfTokenException $e) {}

        $this->assertTrue($this->manager->check('testing', 'valid_token'));
    }

    public function testDifferentTokenIdIsInvalid()
    {
        $this->setExpectedException('\Blockade\Exception\CsrfTokenException');
        $this->manager->check('not-testing', 'token');
    }

    public function testCheckUsesSecureEquals()
    {
        /* $this->driver->expects($this->once()) */
        /*              ->method('secureEquals') */
        /*              ->with(); */
    }

    public function testExceptionHasCsrfDriver()
    {
        try {
            $this->manager->check('foo', 'bar');
        } catch (CsrfTokenException $e) {
            $this->assertInstanceOf('\Blockade\Driver\CsrfDriver', $e->getSecurityDriver());
        }
    }

}