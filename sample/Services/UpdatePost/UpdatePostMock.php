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

use GuzzleHttp\Message\RequestInterface;
use Toplib\GenericApi\ApiFactory;
use Toplib\GenericApi\ApiMockInterface;

/**
 * Class UpdatePostMock
 */
class UpdatePostMock implements ApiMockInterface
{
    /**
     * @inheritDoc
     */
    public function mock(RequestInterface $request)
    {
        return ApiFactory::createResponse($request->getBody()->getContents());
    }
}