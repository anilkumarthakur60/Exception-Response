# Exception Handler for api
## About
The purpose of this method is to handle exceptions that occur during the execution of the application.

The method first checks if the request path matches the pattern 'api/*' or if the request expects a JSON response. If either of these conditions is true, it calls the apiException method and passes in the $request and $exception parameters. This method likely handles the exception and returns a JSON response.

If the request does not match the pattern 'api/*' and does not expect a JSON response, the method calls the parent render method and passes in the $request and $exception parameters. This will likely render a standard error page.

Overall, this code appears to be part of an error handling system that differentiates between API requests and other requests and provides appropriate error responses for each.
##
# Installation
## Composer
```apacheconf
composer require anil/exception-response
```

Use inside  Handler.php
```

use Anil\ExceptionResponse\Traits\ApiExceptionResponse;
class Handler extends ExceptionHandler
{
    use ApiExceptionResponse;
    
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*') || $request->expectsJson()) {

            return $this->apiException($request, $exception);
        }

        return parent::render($request, $exception);
    }
```