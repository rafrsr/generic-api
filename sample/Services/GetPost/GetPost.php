<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\SampleApi\Services\GetPost;

use GuzzleHttp\Message\ResponseInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Toplib\GenericApi\ApiInterface;
use Toplib\GenericApi\ApiServiceInterface;
use Toplib\GenericApi\Serializer\JsonMessageParser;
use Toplib\SampleApi\SampleAPIRequest;

/**
 * Class GetPost
 */
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
     * @param mixed $postId
     *
     * @return $this
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getApiRequest(ApiInterface $api)
    {
        $url = sprintf('/posts/%s', $this->getPostId());

        return new SampleAPIRequest('get', $url, null, new GetPostMock());
    }

    /**
     * @inheritDoc
     */
    public function parseResponse(ResponseInterface $response, ApiInterface $api)
    {
        return new JsonMessageParser('Toplib\SampleApi\Model\Post');
    }
}