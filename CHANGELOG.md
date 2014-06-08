Changelog
=========

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
