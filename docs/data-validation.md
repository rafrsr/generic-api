# Data Validation

Can validate a service data before send the request to a remote server using symfony validation annotations inside the service.

````php
namespace JsonPlaceHolderAPI\Service\DeletePost;

use Symfony\Component\Validator\Constraints as Assert;
use Rafrsr\GenericApi\ApiInterface;
use Rafrsr\GenericApi\ApiRequestBuilder;
use Rafrsr\GenericApi\ApiServiceInterface;

class DeletePost implements ApiServiceInterface
{

    /**
     * @Assert\NotBlank()
     */
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function buildRequest(ApiRequestBuilder $requestBuilder, ApiInterface $api)
    {
        $requestBuilder
            ->withMethod('DELETE')
            ->withUri(sprintf('http://jsonplaceholder.typicode.com/posts/%s', $this->id));
    }
}
````

In this case the property `id` is required and throw a exception of type `InvalidApiDataException` if the `id` is blank.
