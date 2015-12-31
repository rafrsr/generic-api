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

/**
 * This class cane be used to create a service without create the class file,
 * it's very helpful for scaffolding, tests or very small services.
 *
 * ## Example
 *
 * $api = new GenericApi();
 * $request = ApiRequestBuilder::create()
 *   ->withMethod('get')
 *   ->withUri('http://jsonplaceholder.typicode.com/posts/1')
 *   ->getRequest();
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
     * Build the request to send
     *
     * @param ApiRequestBuilder $requestBuilder
     * @param ApiInterface      $api
     */
    public function buildRequest(ApiRequestBuilder $requestBuilder, ApiInterface $api)
    {
        $requestBuilder->setRequest($this->request);
    }
}
