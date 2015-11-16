<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\GenericApi;

use GuzzleHttp\Message\MessageFactory;
use GuzzleHttp\Utils;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;
use Toplib\GenericApi\Client\MockAdapter;
use Toplib\GenericApi\Exception\ApiException;
use Toplib\GenericApi\Exception\ApiInvalidDataException;
use Toplib\GenericApi\Serializer\MessageParserInterface;

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
     * @return bool
     */
    public function isModeSandBox()
    {
        return $this->getMode() == $this::MODE_SANDBOX;
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
    public function isModeLive()
    {
        return $this->getMode() == $this::MODE_LIVE;
    }

    /**
     * @return bool
     */
    public function isModeMock()
    {
        return $this->getMode() == $this::MODE_MOCK;
    }

    /**
     * @inheritDoc
     */
    public function process(ApiServiceInterface $service)
    {
        $this->validate($service);

        $request = $service->getApiRequest($this);

        $httpResponse = $this->sendRequest($request);

        $response = $service->parseResponse($httpResponse, $this);

        if ($response instanceof MessageParserInterface) {
            return $response->parse($httpResponse);
        } else {
            return $response;
        }
    }

    /**
     * @param ApiRequestInterface $request
     *
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
     * @throws ApiException
     */
    protected function sendRequest(ApiRequestInterface $request)
    {
        $clientConfig = [];

        //add mock to client config
        if ($this->isModeMock()) {
            $mock = new MockAdapter(Utils::getDefaultHandler(), new MessageFactory());

            if ($request->getMock()) {
                $mock->setApiServiceMock($request->getMock());
                $clientConfig['fsm'] = $mock;
            } else {
                throw new ApiException('The service can\'t be mocked, should be create a valid mock for this service.');
            }
        }

        return $request->send($clientConfig);
    }

    /**
     * Validate a service data using Symfony validation component
     *
     * @param ApiServiceInterface $service
     *
     * @throws ApiInvalidDataException
     */
    protected function validate(ApiServiceInterface $service)
    {
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $violations = $validator->validate($service, null, true, true);
        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $errorMessage = $violation->getMessage();
            if ($violation->getPropertyPath()) {
                $errorMessage = sprintf('Error in field "%s": ', $violation->getPropertyPath()) . $errorMessage;
            }
            throw new ApiInvalidDataException($errorMessage);
        }
    }
}
