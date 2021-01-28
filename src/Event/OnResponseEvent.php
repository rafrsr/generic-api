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
     * @var \Exception
     */
    protected $exception;

    /**
     * Request execution time in ms
     *
     * @var int
     */
    protected $executionTime = 0;

    /**
     * PreBuildRequestEvent constructor.
     *
     * @param ApiInterface          $api
     * @param ApiServiceInterface   $service
     * @param ResponseInterface     $response
     * @param RequestInterface $request
     * @param \Exception|null $exception
     * @param int $executionTime
     */
    public function __construct(ApiInterface $api, ApiServiceInterface $service, ResponseInterface $response, RequestInterface $request, \Exception $exception = null, $executionTime = 0)
    {
        parent::__construct($api, $service);
        $this->response = $response;
        $this->request = $request;
        $this->exception = $exception;
        $this->executionTime = $executionTime;
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

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @return int
     */
    public function getExecutionTime()
    {
        return $this->executionTime;
    }
}