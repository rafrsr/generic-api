<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\SampleApi\Services\UpdatePost;

use GuzzleHttp\Message\ResponseInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Toplib\GenericApi\ApiInterface;
use Toplib\GenericApi\ApiServiceInterface;
use Toplib\GenericApi\Serializer\JsonMessageParser;
use Toplib\SampleApi\Model\Post;
use Toplib\SampleApi\SampleAPIRequest;

/**
 * Class UpdatePost
 */
class UpdatePost implements ApiServiceInterface
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
    public function getApiRequest(ApiInterface $api)
    {
        $url = sprintf('/posts/%s', $this->getPost()->getId());

        return new SampleAPIRequest('put', $url, $this->getPost(), new UpdatePostMock());
    }

    /**
     * @inheritDoc
     */
    public function parseResponse(ResponseInterface $response, ApiInterface $api)
    {
        return new JsonMessageParser('Toplib\SampleApi\Model\Post');
    }
}