# Building the Request

Each service has a method called buildRequest and receive a ApiRequestBuilder instance as a first argument. This object is used to create a request that will be send to a remote server.

#### withMethod 

When creating a request, you are expected to provide the HTTP method you wish to perform. You can specify any method you'd like, including a custom method that might not be part of RFC 7231 (like "MOVE").

You can create and send a request using methods on a client that map to the HTTP method you wish to use.

Common HTTP methods

* GET
* POST
* HEAD
* PUT
* DELETE
* OPTIONS
* PATCH

````php
$requestBuilder->withMethod ('GET');
````

#### withUri

When creating a request, you can provide the URI as a string or an instance of Psr\Http\Message\UriInterface.

````php
$requestBuilder->withUri('http://jsonplaceholder.typicode.com/posts/');
````

#### withHeaders

Array of headers to send with the request

````php
$requestBuilder->withHeaders(['X-Foo' => 'bar']);
````

#### withBody

Body content to send with the request can be string or `Psr\Http\Message\StreamInterface`

````php
$requestBuilder->withBody({"id":1, "title": "updated"});
````

#### withProtocol

Protocol version to use. The version string MUST contain only the HTTP version number (e.g.,* "1.1", "1.0").

````php
$requestBuilder->withProtocol('1.1');
````

#### withMock

Class to emulate response, string with class name or instance of `Rafrsr\GenericApi\ApiMockInterface`

````php
$requestBuilder->withMock(GetPostsMock::class);
````
More info about [mocks](/rafrsr/generic-api/wiki/Mocking-a-service)

#### Options

Can customize requests created and transferred by a client using request options. Request options control various aspects of a request including, headers, query string parameters, timeout settings, the body of a request, and much more.

````php
$requestBuilder->options()->SSLVerification(false)
````

Can see al available options and specific documentation in the [guzzle documentation page](http://docs.guzzlephp.org/en/latest/request-options.html)

Unlike guzzle, to simplify the usage of set options, we have implemented a method for each option. Can set all options in your prefered way.

````php
$requestBuilder->options()->SSLVerification(false)
//or
$requestBuilder->options()->set('verify', false)
````
