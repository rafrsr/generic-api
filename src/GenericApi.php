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
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;
use Rafrsr\GenericApi\Client\MockHandler;
use Rafrsr\GenericApi\Exception\ApiException;
use Rafrsr\GenericApi\Exception\InvalidApiDataException;

/**
 * Class GenericApi
 */
class GenericApi implements ApiInterface
{

    /**
     * one of the ApiInterface constant modes
     *
     * @var string
     */
    protected $mode;

    /**
     * @param string $mode
     */
    public function __construct($mode = self::MODE_LIVE)
    {
        $this->mode = $mode;
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
     * @inheritDoc
     */
    public function process(ApiServiceInterface $service)
    {
        $this->validate($service);

        $requestBuilder = $this->makeRequestBuilder();

        $service->buildRequest($requestBuilder, $this);

        $httpResponse = $this->sendRequest($requestBuilder->getRequest());

        if ($responseParser = $requestBuilder->getResponseParser()) {
            if ($newResponse = $responseParser->parse($httpResponse)) {
                return $newResponse;
            }
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
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $violations = $validator->validate($service);
        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $errorMessage = $violation->getMessage();
            if ($violation->getPropertyPath()) {
                $errorMessage = sprintf('Error in field "%s": ', $violation->getPropertyPath()) . $errorMessage;
            }
            throw new InvalidApiDataException($errorMessage);
        }
    }
}
