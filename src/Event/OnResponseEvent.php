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

use Psr\Http\Message\RequestInterface;
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
     * @var RequestInterface
     */
    protected $request;

    /**
     * PreBuildRequestEvent constructor.
     *
     * @param ApiInterface          $api
     * @param ApiServiceInterface   $service
     * @param ResponseInterface     $response
     * @param RequestInterface|null $request TODO: mark as required in v3.0
     */
    public function __construct(ApiInterface $api, ApiServiceInterface $service, ResponseInterface $response, RequestInterface $request = null)
    {
        parent::__construct($api, $service);
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }
}