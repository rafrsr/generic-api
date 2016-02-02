<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\SampleApi\Services\DeletePost;

use Symfony\Component\Validator\Constraints as Assert;
use Rafrsr\GenericApi\ApiInterface;
use Rafrsr\GenericApi\ApiRequestBuilder;
use Rafrsr\SampleApi\Services\UpdatePost\UpdatePost;

/**
 * Class DeletePost
 */
class DeletePost extends UpdatePost
{

    /**
     * @inheritDoc
     */
    public function buildRequest(ApiRequestBuilder $requestBuilder, ApiInterface $api)
    {
        $requestBuilder
            ->withMethod('DELETE')
            ->withUri($this->buildServiceUrl('/posts/%s', [$this->getPost()->getId()]))
            ->withMock('Rafrsr\SampleApi\Services\DeletePost\DeletePostMock');
    }
}