<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\SampleApi\Services\GetPost;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Rafrsr\GenericApi\ApiMockInterface;

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
        return new Response(200, [], file_get_contents(__DIR__ . '/../../Fixtures/post1.json'));
    }
}