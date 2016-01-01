# Generic API

[![Build Status](https://travis-ci.org/toplib/generic-api.svg?branch=master)](https://travis-ci.org/toplib/generic-api)
[![Coverage Status](https://coveralls.io/repos/toplib/generic-api/badge.svg?branch=master&service=github)](https://coveralls.io/github/toplib/generic-api?branch=master)
[![Latest Stable Version](https://poser.pugx.org/toplib/generic-api/version)](https://packagist.org/packages/toplib/generic-api)
[![Latest Unstable Version](https://poser.pugx.org/toplib/generic-api/v/unstable)](//packagist.org/packages/toplib/generic-api)
[![Total Downloads](https://poser.pugx.org/toplib/generic-api/downloads)](https://packagist.org/packages/toplib/generic-api)
[![License](https://poser.pugx.org/toplib/generic-api/license)](https://packagist.org/packages/toplib/generic-api)

API Abstraction layer with mocks. Tools for creating structured SDKs or API implementations easy and following some simple guidelines.

Most APIs provide a SDK or API implementation library in parallel.
But this not always true, or simply not made in our required language (php).
For this cases is necessary implements the API from scratch.
GenericApi is solution to keep things organized and follow a similar pattern for all libraries.

## Features

- **Guzzle:** Use guzzle with psr7 for requests, responses, and streams.
- **Mocks:** Emulate request and response for test environments
- **Validation:** Use powerful symfony validations to validate a request before send to a server
- **Connection Abstraction:** Only create the request, the connection is done automatically with guzzle, no more complicated curl connections.
- **Xml and Json Parser:** Can use XML and JSON parser to convert API response to objects using JMS serializer
- **Scaffolding:** Test API connection and any method using generic classes

## Installation

1. [Install composer](https://getcomposer.org/download/)
2. Execute: `composer require toplib/generic-api`

## Implementing specific API

### Creating the API

Firstly create a empty class for your API that extends of GenericApi class. Some methods will be created later.

````php
use Toplib\GenericApi\GenericApi;
class SampleAPI extends GenericApi
{
````

### Creating a Service

A service is the class required to do some specific action, ej. DeleteUser is the service to delete some specific user.

Each service must implements ApiServiceInterface.
Should return a valid `ApiRequest` in the method `getApiRequest` and should parse the response in the method `parseResponse`.
The response can vary depending of your needs.

````php
use Toplib\GenericApi\ApiServiceInterface;
use Toplib\GenericApi\Serializer\JsonMessageParser;

class GetPost implements ApiServiceInterface
{
    /**
     * @Assert\NotBlank()
     */
    private $postId;

    /**
     * GetPost constructor.
     *
     * @param $postId
     */
    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @inheritDoc
     */
    public function buildRequest(ApiRequestBuilder $requestBuilder, ApiInterface $api)
    {
        $requestBuilder
            ->withMethod('GET')
            ->withUri(sprintf('http://jsonplaceholder.typicode.com/posts/%s', $this->getPostId()))
            ->withMock('Toplib\SampleApi\Services\GetPost\GetPostMock')
            ->withJsonResponse('Toplib\SampleApi\Model\Post');
    }
}
````

> Note: No communication happen in the service, only build the request required to send to the external server.

When create the request in the service can customize a lot of options to create advanced requests

````php

$requestBuilder
        ->options()
        ->SSLVerification(false)
        ->setJson(['post'=>['id'=>1]])
        ->setAuth('username','password')
        ->setCurlOption(CURLOPT_CAPATH,'/var/...')
        ...

````

To view all available options see the [guzzle documentation](http://docs.guzzlephp.org/en/latest/request-options.html).

### Create the public method in the API class

This is the user/developer end-point to use the api, you must create a way to call the service

````php
/**
 * Class SampleAPI
 */
class SampleAPI extends GenericApi
{

    /**
     * @param $id
     *
     * @return Post
     * @throws \Toplib\GenericApi\Exception\ApiException
     */
    public function getPost($id)
    {
        $service = new GetPost();
        $service->setPostId($id);

        return $this->process($service);
    }
}
````

alternatively without create the public method, the service can be used as is.

````php
    $api = new SampleApi();
    $service = new GetPost();
    $service->setPostId(1);
    $response = $api->process($service);
    //parse the response
````

But use a public method is very easy

````php
    $api = new SampleApi();
    $post = $api->get(1);
````

### Validation

Validate service data before send the request to a remote server. Use Symfony validation annotations.

````php
    /**
     * @Assert\NotBlank()
     */
    private $postId;
````

Validations are triggered just before send the request to a remote server or mock.

### Serialization

Generic APi can use JMSSerializer to serialize/deserialize when send and receive data.

````php
   ...
  $requestBuilder
              ->withJsonBody($data)
              ->withJsonResponse('Toplib\SampleApi\Model\Post');
````

In any case can use your custom parser

````php
 ...
   $requestBuilder
               ->withCustomResponse(new CustomJsonParser());

````

In case not set a response parser a native guzzle response will be returned

### Mocking a service

The mock is a optional when build the request in the service and emulate the HTTP layer without needing to send requests over the internet.
Mocks are very useful to emulate responses for test environments, developing or refactoring the api implementation without need of send real requests.

````php

use use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Toplib\GenericApi\ApiMockInterface;

/**
 * Class GetPostMock
 */
class GetPostMock implements ApiMockInterface
{
    /**
     * @inheritDoc
     */
    public function mock(RequestInterface $request)
    {
        $post = [
            'userId' => 1,
            'id' => 1,
            'title' => 'sunt aut facere repellat provident ...',
            'body' => 'quia et suscipit suscipit recusandae consequuntur expedita ...',
        ];

        return new Response(200, [], json_encode($post, 1));
    }
}

````

should be settled when create the request in the service

````php
    $requestBuilder
                ->withMock('Toplib\SampleApi\Services\GetPost\GetPostMock')
````

and change the mode of your API

````php
$api->setMode(ApiInterface::MODE_MOCK);
````

### Generic classes for Scaffolding

For rapid scaffolding, tests or small services can use generic classes as is.
Without the need of create a class for that service.

````php
$api = new GenericApi(ApiInterface::MODE_LIVE);

$request = ApiRequestBuilder::create()
    ->withMethod('get')
    ->withUri('http://jsonplaceholder.typicode.com/posts/1')
    ->getRequest();
$service = new GenericApiService($request);
$response = $api->process($service);
````

Below the same example but mocking the response. Generic mock can be created using a callable function in this case.

````php
$api = new GenericApi(ApiInterface::MODE_MOCK);

$mockCallback = function (RequestInterface $request) {
    $post = [
        'userId' => 1,
        'id' => 1,
        'title' => 'sunt aut facere repellat provident occaecati excepturi optio reprehenderit',
        'body' => 'quia et suscipit suscipit recusandae consequuntur expedita et cum reprehenderit molestiae ut ut quas totam nostrum rerum est autem sunt rem eveniet architecto',
    ];

    return new Response(200, [], json_encode($post, 1));
};

$request = ApiRequestBuilder::create()
    ->withMethod('get')
    ->withUri('http://jsonplaceholder.typicode.com/posts/1')
    ->withMock(new GenericApiMock($mockCallback))
    ->getRequest();

$service = new GenericApiService($request);
$response = $api->process($service);
````

## Functional Example

Can view a more complex example of functional API in the "sample" folder.

## Copyright

This project is licensed under the [MIT license](LICENSE).