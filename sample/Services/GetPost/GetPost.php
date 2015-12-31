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

use Symfony\Component\Validator\Constraints as Assert;
use Toplib\GenericApi\ApiInterface;
use Toplib\GenericApi\ApiRequestBuilder;
use Toplib\SampleApi\Services\BasePostService;

/**
 * Class GetPost
 */
class GetPost extends BasePostService
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
    public function buildRequest(ApiRequestBuilder $requestBuilder, ApiInterface $api)
    {
        $requestBuilder
            ->withMethod('GET')
            ->withUri($this->buildServiceUrl('/posts/%s', [$this->getPostId()]))
            ->withMock('Toplib\SampleApi\Services\GetPost\GetPostMock')
            ->withJsonResponse('Toplib\SampleApi\Model\Post');
    }
}