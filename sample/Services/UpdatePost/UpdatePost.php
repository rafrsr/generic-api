<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\SampleApi\Services\UpdatePost;

use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Validator\Constraints as Assert;
use Rafrsr\GenericApi\ApiInterface;
use Rafrsr\GenericApi\ApiRequestBuilder;
use Rafrsr\SampleApi\Model\Post;
use Rafrsr\SampleApi\Services\BasePostService;

/**
 * Class UpdatePost
 */
class UpdatePost extends BasePostService
{

    /**
     * @var Post
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    private $post;

    /**
     * UpdatePost constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Post $post
     *
     * @return $this
     */
    public function setPost(Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function buildRequest(ApiRequestBuilder $requestBuilder, ApiInterface $api)
    {
        $requestBuilder
            ->withMethod('PUT')
            ->withUri($this->buildServiceUrl('/posts/%s', [$this->getPost()->getId()]))
            ->withJsonResponse('Rafrsr\SampleApi\Model\Post')
            ->withMock('Rafrsr\SampleApi\Services\UpdatePost\UpdatePostMock')
            ->options()->setFormParams(json_decode(SerializerBuilder::create()->build()->serialize($this->post, 'json'), true));
    }
}