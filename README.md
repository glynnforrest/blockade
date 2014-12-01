# Blockade

[![Build Status](https://travis-ci.org/glynnforrest/blockade.png)](https://travis-ci.org/glynnforrest/blockade)

Blockade is an easy to use firewall and security library for PHP and
the Symfony HttpKernel.

It uses the `kernel.exception` event to listen for instances of
`BlockadeException` and return a response, depending on the type of
exception thrown. These exceptions can be thrown at any point in the
request, and it's straightforward to create custom exceptions.

Resolvers are responsible for converting an exception to a response,
such as an access denied page or a redirect to a login form. A single
resolver doesn't have to support every exception or return a
response. For example, a resolver that logs unauthorized requests
would only listens for `AuthorizationException`, leaving another
resolver to create a response.

A `FirewallListener` can be set up to check incoming requests and
throw `AuthenticationException`, `AuthorizationException` and
`AnonymousException` for you.

## Installation

Blockade is installed via Composer. To add it to your project, simply add it to your
composer.json file:

```json
{
    "require": {
        "glynnforrest/blockade": "0.1.*"
    }
}
```
And run composer to update your dependencies:

```bash
$ curl -s http://getcomposer.org/installer | php
$ php composer.phar update
```

## License

MIT, see LICENSE for details.

Copyright 2014 Glynn Forrest
