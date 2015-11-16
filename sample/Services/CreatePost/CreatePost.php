<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\SampleApi\Services\CreatePost;

use GuzzleHttp\Message\ResponseInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Toplib\GenericApi\ApiInterface;
use Toplib\GenericApi\Serializer\JsonMessageParser;
use Toplib\SampleApi\SampleAPIRequest;
use Toplib\SampleApi\Services\UpdatePost\UpdatePost;

/**
 * Class CreatePost
 */
class CreatePost extends UpdatePost
{
    /**
     * @inheritDoc
     */
    public function getApiRequest(ApiInterface $api)
    {
        return new SampleAPIRequest('post', '/posts', $this->getPost(), new CreatePostMock());
    }

    /**
     * @inheritDoc
     */
    public function parseResponse(ResponseInterface $response, ApiInterface $api)
    {
        return new JsonMessageParser('Toplib\SampleApi\Model\Post');
    }
}