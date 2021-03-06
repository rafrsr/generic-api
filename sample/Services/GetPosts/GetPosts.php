<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\SampleApi\Services\GetPosts;

use Symfony\Component\Validator\Constraints as Assert;
use Rafrsr\GenericApi\ApiInterface;
use Rafrsr\GenericApi\ApiRequestBuilder;
use Rafrsr\SampleApi\Services\BasePostService;

/**
 * Class GetPosts
 */
class GetPosts extends BasePostService
{
    /**
     * @var int
     */
    private $userId;

    /**
     * GetPosts constructor.
     *
     * @param int $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function buildRequest(ApiRequestBuilder $requestBuilder, ApiInterface $api)
    {
        $requestBuilder
            ->withMethod('GET')
            ->withUri($this->buildServiceUrl('/posts/'))
            ->withJsonResponse('array<Rafrsr\SampleApi\Model\Post>')
            ->withMock('Rafrsr\SampleApi\Services\GetPosts\GetPostsMock');

        if ($this->getUserId()) {
            $requestBuilder->options()->addQuery('userId', $this->getUserId());
        }
    }
}