<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\GenericApi;

/**
 * Class GenericApiServices
 */
interface ApiServiceInterface
{
    /**
     * Build the request to send
     *
     * @param ApiRequestBuilder $requestBuilder
     * @param ApiInterface      $api
     *
     * @return
     */
    public function buildRequest(ApiRequestBuilder $requestBuilder, ApiInterface $api);
}