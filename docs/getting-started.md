# Getting Started

As a demostration implement an API to connect to http://jsonplaceholder.typicode.com and get the list of posts.

### Creating the API implementation

Firstly create a empty class for your API that extends of GenericApi class. Some methods will be created later.

````php
namespace JsonPlaceHolderAPI

use Rafrsr\GenericApi\GenericApi;
use Rafrsr\SampleApi\Services\PostsServices;

class JsonPlaceHolderAPI extends GenericApi
{
   
}

````


### Creating the first service to get the list of posts

A service is the class required to do some specific action, ej. GetPosts, DeletePost.
Each service must implements `ApiServiceInterface`.

```php
namespace JsonPlaceHolderAPI\Service

use Rafrsr\GenericApi\ApiInterface;
use Rafrsr\GenericApi\ApiRequestBuilder;
use Rafrsr\GenericApi\ApiServiceInterface;

class GetPosts implements ApiServiceInterface
{
    /**
     * @inheritDoc
     */
    public function buildRequest(ApiRequestBuilder $requestBuilder, ApiInterface $api)
    {
        $requestBuilder
            ->withMethod('GET')
            ->withUri('http://jsonplaceholder.typicode.com/posts/');
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

### Create the public method in the API class

This is the user/developer end-point to use the api.

````php
namespace JsonPlaceHolderAPI

use Rafrsr\GenericApi\GenericApi;
use JsonPlaceHolderAPI\Service\GetPosts;

class JsonPlaceHolderAPI extends GenericApi
{
   /**
     * @param $id
     *
     * @return array
     * @throws \Rafrsr\GenericApi\Exception\ApiException
     */
    public function getPost($id)
    {
        $response =  $this->process(new GetPosts());
        
        return json_decode($response->getBody()->getContents(), true);
    }
}

````

### Usage of the new JsonPlaceHolderAPI

````php
$api = new JsonPlaceHolderAPI();
$posts = $api->getPosts();
foreach ($post as $post){
  echo $post['title'] . "\n";
}
````
