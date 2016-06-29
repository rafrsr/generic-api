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

use Psr\Http\Message\ResponseInterface;
use Rafrsr\GenericApi\ApiInterface;
use Rafrsr\GenericApi\ApiServiceInterface;

class OnResponseEvent extends ApiEvent
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * PreBuildRequestEvent constructor.
     *
     * @param ApiInterface        $api
     * @param ApiServiceInterface $service
     * @param ResponseInterface $response
     */
    public function __construct(ApiInterface $api, ApiServiceInterface $service, ResponseInterface $response)
    {
        parent::__construct($api, $service);
        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}