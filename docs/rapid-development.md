# Rapid development and Scaffolding

For rapid development, scaffolding, tests or small services can use generic classes as is.
Without the need of create a class for each service.

````php
$api = new GenericApi(ApiInterface::MODE_LIVE);
$request = ApiRequestBuilder::create()
    ->withMethod('get')
    ->withUri('http://jsonplaceholder.typicode.com/posts/1')
    ->getRequest();
$service = new GenericApiService($request);
$response = $api->process($service);
````
Mock the response is possible too with generic classes. In these cases a generic mock is created using a closure and GenericMock instance.

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

> Note: Generic classes are recommended only for scaffolding or simple tests. Never use in real services that can be extended later.
