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

class ApiDebugger
{
    /**
     * @var RequestProcessStack
     */
    protected $requestStack;

    /**
     * makeRequestProcess
     *
     * @param RequestInterface $request
     *
     * @return RequestProcess
     */
    public function beginRequestProcess(RequestInterface $request)
    {
        return new RequestProcess($request);
    }

    /**
     * finishRequestProcess
     *
     * @param RequestProcess    $process
     * @param ResponseInterface $response
     * @param Exception|null    $exception
     */
    public function finishRequestProcess(RequestProcess $process, ResponseInterface $response = null, Exception $exception = null)
    {
        if ($response) {
            $process->setResponse($response);
        }
        if ($exception) {
            $process->setException($exception);
        }
        $this->requestStack[] = $process;
    }

    /**
     * Request stack keep all request and responses during a API session for debugging purposes
     * Requests and responses are saved in native http format
     *
     * @return RequestProcessStack|array|RequestProcess[]
     */
    public function getRequestStack()
    {
        return $this->requestStack;
    }

    /**
     * Clear the current debug session with all requests and responses
     *
     * @return $this
     */
    public function flushRequestStack()
    {
        $this->requestStack = [];

        return $this;
    }
}