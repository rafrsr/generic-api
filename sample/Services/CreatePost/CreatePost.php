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

use Symfony\Component\Validator\Constraints as Assert;
use Toplib\GenericApi\ApiInterface;
use Toplib\GenericApi\ApiRequestBuilder;
use Toplib\SampleApi\Services\UpdatePost\UpdatePost;

/**
 * Class CreatePost
 */
class CreatePost extends UpdatePost
{
    /**
     * @inheritDoc
     */
    public function buildRequest(ApiRequestBuilder $requestBuilder, ApiInterface $api)
    {
        parent::buildRequest($requestBuilder, $api);

        $requestBuilder
            ->withMethod('POST')
            ->withUri($this->buildServiceUrl('/posts/'))
            ->withMock('Toplib\SampleApi\Services\CreatePost\CreatePostMock');
    }
}