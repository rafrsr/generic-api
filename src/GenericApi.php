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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Rafrsr\GenericApi\Client\MockHandler;
use Rafrsr\GenericApi\Debug\ApiDebugger;
use Rafrsr\GenericApi\Event\OnResponseEvent;
use Rafrsr\GenericApi\Event\PreBuildRequestEvent;
use Rafrsr\GenericApi\Event\PreSendRequestEvent;
use Rafrsr\GenericApi\Exception\ApiException;
use Rafrsr\GenericApi\Exception\InvalidApiDataException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

/**
 * Class GenericApi
 */
class GenericApi implements ApiInterface
{
    const EVENT_PRE_BUILD_REQUEST = 'api_pre_build_request';
    const EVENT_PRE_SEND_REQUEST = 'api_pre_send_request';
    const EVENT_ON_RESPONSE = 'api_on_response';

    /**
     * one of the ApiInterface constant modes
     *
     * @var string
     */
    protected $mode;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var ApiDebugger
     */
    protected $debugger;

    /**
     * @param string  $mode
     * @param boolean $debug
     */
    public function __construct($mode = self::MODE_LIVE, $debug = false)
    {
        $this->mode = $mode;
        $this->eventDispatcher = new EventDispatcher();

        if ($debug) {
            $this->debugger = new ApiDebugger();
        }
    }

    /**
     * @inheritDoc
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param string $mode one of the ApiInterface constant modes
     *
     * @return $this
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return bool
     */
    public function isModeSandBox()
    {
        return $this->getMode() === $this::MODE_SANDBOX;
    }

    /**
     * @return bool
     */
    public function isModeLive()
    {
        return $this->getMode() === $this::MODE_LIVE;
    }

    /**
     * @return bool
     */
    public function isModeMock()
    {
        return $this->getMode() === $this::MODE_MOCK;
    }

    /**
     * @return EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * Return debugger instance or null if the debugger is disabled
     *
     * @return ApiDebugger|null
     */
    public function getDebugger()
    {
        return $this->debugger;
    }

    /**
     * @inheritDoc
     */
    public function process(ApiServiceInterface $service)
    {
        $this->validate($service);

        $requestBuilder = $this->makeRequestBuilder();

        $this->getEventDispatcher()->dispatch(new PreBuildRequestEvent($this, $service, $requestBuilder), self::EVENT_PRE_BUILD_REQUEST);

        $service->buildRequest($requestBuilder, $this);
        $request = $requestBuilder->getRequest();

        $this->getEventDispatcher()->dispatch(new PreSendRequestEvent($this, $service, $request), self::EVENT_PRE_SEND_REQUEST);

        $debugProcess = null;
        if ($this->debugger) {
            $debugProcess = $this->debugger->beginRequestProcess($request);
        }

        $exception = null;
        $httpResponse = null;
        $startTime = microtime(true) * 1000;
        try {
            $httpResponse = $this->sendRequest($request);
        } catch (RequestException $e) {
            $httpResponse = $e->getResponse();
            //silent exception during debug
            $exception = $e;
        }

        $executionTime = number_format((microtime(true) * 1000) - $startTime, 0, '', '');

        if ($debugProcess !== null) {
            $this->debugger->finishRequestProcess($debugProcess, $httpResponse, $exception, $executionTime);
        }

        $newResponse = null;
        if (!$exception && $responseParser = $requestBuilder->getResponseParser()) {
            try {
                $newResponse = $responseParser->parse($httpResponse);
            } catch (\Exception $e) {
                $exception = $e;
            }
        }

        if ($httpResponse) {
            $this->getEventDispatcher()->dispatch(new OnResponseEvent($this, $service, $httpResponse, $request, $exception, $executionTime), self::EVENT_ON_RESPONSE);
        }

        //has pending exception
        if ($exception && $exception instanceof \Exception) {
            throw $exception;
        }

        if ($newResponse) {
            return $newResponse;
        }

        return $httpResponse;
    }

    /**
     * Can override this method to make
     * custom request builder if needed
     *
     * @return ApiRequestBuilder
     */
    protected function makeRequestBuilder()
    {
        return new ApiRequestBuilder();
    }

    /**
     * @param ApiRequestInterface $request
     *
     * @return ResponseInterface
     * @throws ApiException
     */
    protected function sendRequest(ApiRequestInterface $request)
    {
        $clientOptions = [];

        //add mock to client config
        if ($this->isModeMock()) {
            if ($request->getMock()) {
                $mockHandler = new MockHandler($request->getMock());
                $clientOptions['handler'] = $mockHandler;
            } else {
                throw new ApiException('The service can\'t be mocked, should create a valid mock for this service.');
            }
        }

        return $this->buildClient($clientOptions)->send($request, $request->getOptions()->getAll());
    }

    /**
     * Build a guzzle client,
     * override if is needed more specific client
     *
     * @param $clientOptions
     *
     * @return Client
     */
    protected function buildClient($clientOptions)
    {
        return new Client($clientOptions);
    }

    /**
     * Validate a service data using Symfony validation component
     *
     * @param ApiServiceInterface $service
     *
     * @throws InvalidApiDataException
     */
    protected function validate(ApiServiceInterface $service)
    {
        $builder = Validation::createValidatorBuilder();

        //since symfony/validator 5.2 Not passing true as first argument to "%s" is deprecated.
        if (method_exists($builder, 'addDefaultDoctrineAnnotationReader')) {
            $builder->enableAnnotationMapping(true);
            $builder->addDefaultDoctrineAnnotationReader();
        } else {
            $builder->enableAnnotationMapping();
        }

        $validator = $builder->getValidator();
        $violations = $validator->validate($service);
        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $errorMessage = $violation->getMessage();
            if ($violation->getPropertyPath()) {
                $errorMessage = sprintf('Error in field "%s": ', $violation->getPropertyPath()).$errorMessage;
            }
            throw new InvalidApiDataException($errorMessage);
        }
    }

    /**
     * Event triggered before build the request
     * Rafrsr\GenericApi\Event\PreBuildRequestEvent is received as first param
     *
     * @param callable $callback
     */
    public function preBuildRequest(callable $callback)
    {
        $this->getEventDispatcher()->addListener(self::EVENT_PRE_BUILD_REQUEST, $callback);
    }

    /**
     * Event triggered before send the request
     * Rafrsr\GenericApi\Event\PreSendRequestEvent is received as first param
     *
     * @param callable $callback
     */
    public function preSendRequest(callable $callback)
    {
        $this->getEventDispatcher()->addListener(self::EVENT_PRE_SEND_REQUEST, $callback);
    }

    /**
     * Event triggered on receive a response
     * Rafrsr\GenericApi\Event\OnResponseEvent is received as first param
     *
     * @param callable $callback
     */
    public function onResponse(callable $callback)
    {
        $this->getEventDispatcher()->addListener(self::EVENT_ON_RESPONSE, $callback);
    }
}
