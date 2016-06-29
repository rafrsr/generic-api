<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\GenericApi\Event;

use Rafrsr\GenericApi\ApiInterface;
use Rafrsr\GenericApi\ApiRequestBuilder;
use Rafrsr\GenericApi\ApiServiceInterface;

class PreBuildRequestEvent extends ApiEvent
{
    /**
     * @var ApiRequestBuilder
     */
    protected $requestBuilder;

    /**
     * PreBuildRequestEvent constructor.
     *
     * @param ApiInterface        $api
     * @param ApiServiceInterface $service
     * @param ApiRequestBuilder   $requestBuilder
     */
    public function __construct(ApiInterface $api, ApiServiceInterface $service, ApiRequestBuilder $requestBuilder)
    {
        parent::__construct($api, $service);
        $this->requestBuilder = $requestBuilder;
    }

    /**
     * @return ApiRequestBuilder
     */
    public function getRequestBuilder()
    {
        return $this->requestBuilder;
    }
}