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

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Rafrsr\GenericApi\Client\RequestOptions;
use Rafrsr\GenericApi\Serializer\CallbackMessageParser;
use Rafrsr\GenericApi\Serializer\JsonMessageParser;
use Rafrsr\GenericApi\Serializer\MessageParserInterface;
use Rafrsr\GenericApi\Serializer\XMLMessageParser;

/**
 * Class RequestBuilder
 */
class ApiRequestBuilder
{

    /**
     * @var ApiMockInterface
     */
    protected $mock;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string|UriInterface
     */
    protected $uri;

    /**
     * @var string|resource|StreamInterface
     */
    protected $body;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $protocol = 1.1;

    /**
     * @var RequestOptions
     */
    protected $options;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var MessageParserInterface
     */
    protected $responseParser;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->options = new RequestOptions();
    }

    /**
     * create
     *
     * @return ApiRequestBuilder
     */
    public static function create()
    {
        return new ApiRequestBuilder();
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function withMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return UriInterface|string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param UriInterface|string $uri
     *
     * @return $this
     */
    public function withUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return StreamInterface|resource|string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param StreamInterface|resource|string $body
     *
     * @return $this
     */
    public function withBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     *
     * @return $this
     */
    public function withHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     *
     * @return $this
     */
    public function withProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * Request options
     *
     * @return RequestOptions
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * @return ApiMockInterface
     */
    public function getMock()
    {
        return $this->mock;
    }

    /**
     * @param string|ApiMockInterface $mock class name of instance implemetings ApiMockInterface
     *
     * @return $this
     */
    public function withMock($mock)
    {
        if (is_string($mock)) {
            $mock = new $mock;
        }

        $this->mock = $mock;

        return $this;
    }

    /**
     * @return ApiRequestInterface
     */
    public function getRequest()
    {
        if (!$this->request) {
            $this->request = new ApiRequest(
                $this->getMethod(),
                $this->getUri(),
                $this->getHeaders(),
                $this->getBody(),
                $this->getProtocol()
            );

            if ($this->mock) {
                $this->request->withMock($this->mock);
            }

            $this->request->withOptions($this->options);
        }

        return $this->request;
    }

    /**
     * @return MessageParserInterface
     */
    public function getResponseParser()
    {
        return $this->responseParser;
    }

    /**
     * Create json with given data using serialization
     *
     * @param                           $data
     * @param SerializationContext|null $context
     *
     * @return $this
     */
    public function withJsonBody($data, SerializationContext $context = null)
    {
        if (is_string($data)) {
            $json = $data;
        } else {
            $json = SerializerBuilder::create()->build()->serialize($data, 'json', $context);
        }
        $this->withBody($json);

        return $this;
    }

    /**
     * Create xml with given data using serialization
     *
     * @param                           $data
     * @param SerializationContext|null $context
     *
     * @return $this
     */
    public function withXMLBody($data, SerializationContext $context = null)
    {
        if (is_string($data)) {
            $xml = $data;
        } else {
            $xml = SerializerBuilder::create()->build()->serialize($data, 'xml', $context);
        }
        $this->addHeader('Content-Type', 'text/xml; charset=utf-8');
        $this->withBody($xml);

        return $this;
    }

    /**
     * @param                        $class   string|object $class class to unserialize the response, otherwise return a array
     * @param DeserializationContext $context context
     * @param SerializerInterface|null $serializer use custom serializer
     *
     * @return $this
     */
    public function withJsonResponse($class = null, DeserializationContext $context = null, SerializerInterface $serializer = null)
    {
        $this->responseParser = new JsonMessageParser($class, $context, $serializer);

        return $this;
    }

    /**
     * @param string|object            $class                   class to unserialize the response, otherwise return a array
     * @param DeserializationContext   $context                 context
     * @param boolean                  $removeNamespacePrefixes remove all namespaces prefixes before deserialize
     * @param SerializerInterface|null $serializer              use custom serializer
     *
     * @return $this
     */
    public function withXmlResponse($class = null, DeserializationContext $context = null, $removeNamespacePrefixes = false, SerializerInterface $serializer = null)
    {
        $this->responseParser = new XMLMessageParser($class, $context, $removeNamespacePrefixes, $serializer);

        return $this;
    }

    /**
     * Set a callback to process the response and return custom response object
     * the callback receive a Psr\Http\Message\MessageInterface as first argument
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function withCallbackResponse(callable $callback)
    {
        $this->responseParser = new CallbackMessageParser($callback);

        return $this;
    }

    /**
     * @param MessageParserInterface $responseParser
     *
     * @return $this
     */
    public function withCustomResponse(MessageParserInterface $responseParser)
    {
        $this->responseParser = $responseParser;

        return $this;
    }

    /**
     * Use custom request instance
     *
     * @param ApiRequestInterface $request
     *
     * @return $this
     */
    public function setRequest(ApiRequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }
}