<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\SampleApi\Services\GetPosts;

use GuzzleHttp\Message\ResponseInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Toplib\GenericApi\ApiInterface;
use Toplib\GenericApi\ApiServiceInterface;
use Toplib\GenericApi\Serializer\JsonMessageParser;
use Toplib\SampleApi\SampleAPIRequest;

/**
 * Class GetPosts
 */
class GetPosts implements ApiServiceInterface
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
    public function getApiRequest(ApiInterface $api)
    {
        $request = new SampleAPIRequest('get', '/posts', null, new GetPostsMock());

        if ($this->getUserId()) {
            $request->addQuery('userId', $this->getUserId());
        }

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function parseResponse(ResponseInterface $response, ApiInterface $api)
    {
        return new JsonMessageParser('array<Toplib\SampleApi\Model\Post>');
    }
}