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
use Rafrsr\GenericApi\ApiRequestInterface;
use Rafrsr\GenericApi\ApiServiceInterface;

class PreSendRequestEvent extends ApiEvent
{
    /**
     * @var ApiRequestInterface
     */
    protected $request;

    /**
     * PreBuildRequestEvent constructor.
     *
     * @param ApiInterface        $api
     * @param ApiServiceInterface $service
     * @param ApiRequestInterface $request
     */
    public function __construct(ApiInterface $api, ApiServiceInterface $service, ApiRequestInterface $request)
    {
        parent::__construct($api, $service);
        $this->request = $request;
    }

    /**
     * @return ApiRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }
}