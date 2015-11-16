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
 * Class GenericApiServices
 */
interface ApiServiceInterface
{
    /**
     * Generate the request for current service
     *
     * @param ApiInterface $api
     *
     * @return ApiRequestInterface
     */
    public function getApiRequest(ApiInterface $api);

    /**
     * Parse and normalize the response of service
     *
     * @param ResponseInterface $response
     * @param ApiInterface      $api
     *
     * @return mixed
     */
    public function parseResponse(ResponseInterface $response, ApiInterface $api);
}