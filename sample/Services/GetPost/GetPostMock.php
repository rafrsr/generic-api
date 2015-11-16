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

use GuzzleHttp\Message\RequestInterface;
use Toplib\GenericApi\ApiFactory;
use Toplib\GenericApi\ApiMockInterface;

/**
 * Class GetPostMock
 */
class GetPostMock implements ApiMockInterface
{
    /**
     * @inheritDoc
     */
    public function mock(RequestInterface $request)
    {
        return ApiFactory::createResponse(file_get_contents(__DIR__ . '/../../Fixtures/post1.json'));
    }
}