<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\SampleApi\Services\DeletePost;

use GuzzleHttp\Message\ResponseInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Toplib\GenericApi\ApiInterface;
use Toplib\SampleApi\SampleAPIRequest;
use Toplib\SampleApi\Services\UpdatePost\UpdatePost;

/**
 * Class DeletePost
 */
class DeletePost extends UpdatePost
{
    /**
     * @inheritDoc
     */
    public function getApiRequest(ApiInterface $api)
    {
        $url = sprintf('/posts/%s', $this->getPost()->getId());

        return new SampleAPIRequest('delete', $url, null, new DeletePostMock());
    }

    /**
     * @inheritDoc
     */
    public function parseResponse(ResponseInterface $response, ApiInterface $api)
    {
        return $response;
    }
}