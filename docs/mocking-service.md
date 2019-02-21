# Mocking a Service

Mocks allow emulate the HTTP layer without needing to send requests over the internet.
Mocks are very useful to emulate responses for test environments, developing or refactoring the api implementation without need of send real requests.

### Creating the mock

````php
namespace JsonPlaceHolderAPI\Mock

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Rafrsr\GenericApi\ApiMockInterface;

class GetPostsMock implements ApiMockInterface
{
    /**
     * @inheritDoc
     */
    public function mock(RequestInterface $request)
    {
        $posts = [
            [
             'userId' => 1,
             'id' => 1,
             'title' => 'Sunt aut facere repellat provident',
             'body' => 'Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus.',
            ],
            [
             'userId' => 1,
             'id' => 2,
             'title' => 'Donec rutrum congue leo eget malesuada.',
             'body' => 'Quia et suscipit suscipit recusandae consequuntur expedita.',
            ],
        ];

        return new Response(200, [], json_encode($posts));
    }
}

````

### Defining the mock when build the request

````php
$requestBuilder->withMock(GetPostsMock::class);
````

### Using the mock

By default the API it's in live mode, in that case,  requests are sent to the remote server, to avoid this should change the API mode.

````php
$api = new JsonPlaceHolderAPI();

$api->setMode(ApiInterface::MODE_MOCK);

$posts = $api->getPosts();
foreach ($post as $post){
  echo $post['title'] . "\n";
}
````
> In the above example no comunicacion happened between the API implementation and the remote server. All communication is mocked and the response is obtained from given mock.
