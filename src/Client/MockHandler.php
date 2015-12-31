<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\GenericApi\Client;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Toplib\GenericApi\ApiMockInterface;

/**
 * Adapter to use with Guzzle client to fake connection to the api using ApiMockInterface.
 * This adapter easily mock the HTTP layer without needing to send requests over the internet.
 * This adapter connect to a mock class and call the method mock()
 * with the request as first argument.
 * The response of the fake method should be Response object with similar body to the original api response.
 */
class MockHandler
{
    /**
     * @var ApiMockInterface
     */
    private $mock;

    /**
     * MockHandler constructor.
     *
     * @param ApiMockInterface $mock
     */
    public function __construct(ApiMockInterface $mock)
    {
        $this->mock = $mock;
    }

    /**
     *  __invoke
     *
     * @param RequestInterface $request
     * @param array            $options
     *
     * @return PromiseInterface
     * @throws \Exception
     */
    public function __invoke(RequestInterface $request, array $options)
    {
        $response = $this->mock->mock($request);
        if (!$response instanceof ResponseInterface) {
            throw new \Exception('Invalid mock response, should return a ResponseInterface object instance.');
        }

        return new FulfilledPromise($response);
    }
}