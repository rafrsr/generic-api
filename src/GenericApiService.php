<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\GenericApi;

use GuzzleHttp\Message\ResponseInterface;

/**
 * This class cane be used to create a service without create the class file,
 * it's very helpful for scaffolding, tests or very small services.
 *
 * ## Example
 *
 * $api = new GenericApi();
 * $request = ApiFactory::createRequest('get', 'http://example.org/post/1');
 * $service = new GenericApiService($request);
 * $api->process($service);
 */
final class GenericApiService implements ApiServiceInterface
{

    private $request;

    /**
     * GenericService constructor.
     *
     * @param $request
     */
    public function __construct(ApiRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function getApiRequest(ApiInterface $api)
    {
        return $this->request;
    }

    /**
     * @inheritDoc
     */
    public function parseResponse(ResponseInterface $response, ApiInterface $api)
    {
        return $response;
    }
}
