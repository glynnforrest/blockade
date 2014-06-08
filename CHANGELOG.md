Changelog
=========
### 0.1.2 2014-06-08

Adding a RequestListener to automatically give the Request to
registered drivers. This allows usage of a driver when you don't have
access to the request (e.g. in a template).

### 0.1.1 2014-06-07

Addition of hasRequest() to DriverInterface.

### 0.1.0 2014-04-28

Initial release. Here are the current features:

* A DriverInterface to handle authentication and authorization, and
  dummy 'pass' and 'fail' drivers that implement this interface.
* A Firewall to check if a request is authorized to view the requested
  url, and a FirewallListener to run the firewall on every HttpKernel
  request event.
* A CsrfManager to check submitted forms.
* Exceptions that are thrown for any security issue, such as
  authentication, authorization, session expiry, etc.
* A ResolverInterface which is designed to handle these Exceptions. 3
  resolvers are implemented that log exceptions, deny access and
  redirect to a url.
