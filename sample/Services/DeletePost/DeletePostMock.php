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

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Rafrsr\GenericApi\ApiMockInterface;

/**
 * Class DeletePostMock
 */
class DeletePostMock implements ApiMockInterface
{
    /**
     * @inheritDoc
     */
    public function mock(RequestInterface $request)
    {
        return new Response(200);
    }
}