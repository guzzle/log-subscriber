=====================
Guzzle Log Subscriber
=====================

Logs HTTP requests and responses to a `PSR-3 logger <https://github.com/php-fig/log>`_.

Here's a simple example of how it's used:

.. code-block:: php

    use GuzzleHttp\Client;
    use GuzzleHttp\Subscriber\Log\LogSubscruber;
    use GuzzleHttp\Subscriber\Log\SimpleLogger;

    $client = new Client();

    // The log subscriber requires a PSR-3 logger. Guzzle provides a very
    // simple implementation that can be used to log using echo, a fopen()
    resource, or a callable function.
    $logger = new SimpleLogger();

    $subscriber = new LogSubscriber($logger);

    $client->getEmitter()->addSubscriber($subscriber);

If you just want to quickly debug an issue, you can use the static
``getDebug()`` method of the LogSubscriber.

.. code-block:: php

    $subscriber = LogSubscriber::getDebug();
    $client->addSubscruber($subscriber);

The LogSubscriber's constructor accepts a logger as the first argument and a
message format string or a message formatter as the second argument.

.. code-block:: php

    // Log the full request and response.
    $subscriber = new LogSubscriber($logger, "{request}\n\n{response}");

Message Formatter
-----------------

Included in this repository is a *message formatter*. The message formatter is
used to format log messages for both requests and responses using a log
template that uses variable substitution for string enclosed in braces
(``{}``).

The following variables are available in message formatter templates:

{request}
    Full HTTP request message

{response}
    Full HTTP response message

{ts}
    Timestamp

{host}
    Host of the request

{method}
    Method of the request

{url}
    URL of the request

{protocol}
    Request protocol

{version}
    Protocol version

{resource}
    Resource of the request (path + query + fragment)

{hostname}
    Hostname of the machine that sent the request

{code}
    Status code of the response (if available)

{phrase}
    Reason phrase of the response  (if available)

{error}
    Any error messages (if available)

{req_header_*}
    Replace ``*`` with the lowercased name of a request header to add to the
    message.

{res_header_*}
    Replace ``*`` with the lowercased name of a response header to add to the
    message

{req_headers}
    Request headers as a string.

{res_headers}
    Response headers as a string.

{req_body}
    Request body as a string.

{res_body}
    Response body as a string.
