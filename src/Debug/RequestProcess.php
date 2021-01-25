<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\GenericApi\Debug;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RequestProcess
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Exception
     */
    protected $exception;

    /**
     * @var int
     */
    protected $executionTime = 0;

    /**
     * RequestProcess constructor.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param Exception         $exception
     * @param int               $executionTime
     */
    public function __construct(RequestInterface $request = null, ResponseInterface $response = null, Exception $exception = null, $executionTime = 0)
    {
        $this->request = $request;
        $this->response = $response;
        $this->exception = $exception;
        $this->executionTime = $executionTime;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     *
     * @return $this
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return $this
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     *
     * @return $this
     */
    public function setException(Exception $exception)
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * @return int
     */
    public function getExecutionTime()
    {
        return $this->executionTime;
    }

    /**
     * @param int $executionTime
     *
     * @return $this
     */
    public function setExecutionTime($executionTime)
    {
        $this->executionTime = $executionTime;

        return $this;
    }
}