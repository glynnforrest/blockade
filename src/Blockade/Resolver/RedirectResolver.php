<?php

namespace Blockade\Resolver;

use Blockade\Driver\DriverInterface;
use Blockade\Exception\BlockadeException;
use Blockade\Exception\BlockadeFailureException;
use Blockade\Exception\AuthenticationException;
use Blockade\Exception\CredentialsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * RedirectResolver
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class RedirectResolver implements ResolverInterface
{
    protected $login_url;
    protected $deny_url;

    /**
     * Create a new RedirectResolver. Make sure that $login_url and
     * $deny_url are accessible through any firewalls to avoid a
     * redirect loop.
     */
    public function __construct($login_url = '/login', $deny_url = '/restricted')
    {
        $this->login_url = $login_url;
        $this->deny_url = $deny_url;
    }

    /**
     * Create the url to redirect to.
     *
     * @param BlockadeException $exception The exception
     * @param Request           $request   The request that caused the exception
     */
    protected function createUrl(BlockadeException $exception, Request $request)
    {
        //decide where to redirect. login_url for unauthenticated or
        //bad credentials, deny_url for unauthorized or anything else
        if ($exception instanceof AuthenticationException || $exception instanceof CredentialsException) {
            return $this->login_url.'/to'.$request->getPathInfo();
        }

        return $this->deny_url;
    }

    /**
     * Create a response for XmlHttpRequests.
     *
     * @param BlockadeException $exception The exception
     * @param Request           $request   The request that caused the exception
     */
    protected function createXmlHttpResponse(BlockadeException $exception, Request $request)
    {
        if ($exception instanceof AuthenticationException || $exception instanceof CredentialsException) {
            return new Response('Authentication required', Response::HTTP_UNAUTHORIZED);
        }

        return new Response('Access denied', Response::HTTP_FORBIDDEN);
    }

    public function onException(BlockadeException $exception, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            return $this->createXmlHttpResponse($exception, $request);
        }

        $url = $this->createUrl($exception, $request);

        //check for a potential redirect loop
        if ($request->getPathInfo() === $url && $request->getMethod() === 'GET') {
            throw new BlockadeFailureException(
                sprintf('Circular redirect to %s detected', $url),
                500,
                $exception
            );
        }

        return new RedirectResponse($url);
    }

    public function supportsDriver(DriverInterface $driver)
    {
        return true;
    }

    public function supportsException(BlockadeException $exception)
    {
        return true;
    }
}
