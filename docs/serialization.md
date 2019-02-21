# Serialization

Generic APi can use JMSSerializer to serialize/deserialize when send and receive data.

## Creating model objects

````php
namespace JsonPlaceHolderAPI\Model

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class Post
{
    /**
     * @SerializedName("userId")
     * @Type("integer")
     * @Assert\NotBlank()
     */
    protected $userId;

    /**
     * @var int
     * @Type("integer")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Type("string")
     */
    protected $title;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Type("string")
     */
    protected $body;

....
````

## Updating the service to unserialize the response

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
            ->withUri('http://jsonplaceholder.typicode.com/posts/')
            ->withJsonResponse('array<JsonPlaceHolderAPI\Model\Post>');
    }
}
````

````php
class JsonPlaceHolderAPI extends GenericApi
{
   /**
     * @param $id
     *
     * @return array|Post[]
     * @throws \Rafrsr\GenericApi\Exception\ApiException
     */
    public function getPost($id)
    {
        return $this->process(new GetPosts());
    }
}
````

> Note that is not required the use of json_decode, this is done automatically and the `process()` method now return a array of `Post` objects.

Now the response contains an array of objects instead of arrays

````php
$api = new JsonPlaceHolderAPI();
$posts = $api->getPosts();
foreach ($post as $post){
  echo $post->getTitle() . "\n";
}
````

## Sending serialized data

The submitted body can be serialized using similiar feature when build the request.

````
 $requestBuilder
           //...
            ->withXMLBody($post);
````

In the above example will send a request with serialized `Post` in xml format.

