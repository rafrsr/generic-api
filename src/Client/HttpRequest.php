<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\GenericApi\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJarInterface;

/**
 * This class can be used with Guzzle to create a
 */
class HttpRequest implements HttpRequestInterface
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $options;

    /**
     * Http Request
     *
     * @param string $method  http method to use
     * @param string $url     url to send the request
     * @param array  $options array of guzzle request options
     */
    public function __construct($method, $url, $options = [])
    {
        $this->method = $method;
        $this->url = $url;
        $this->options = $options;
    }

    /**
     * @inheritdoc
     */
    public function send(array $clientConfig = [])
    {
        $client = new Client($clientConfig);

        $guzzleRequest = $client->createRequest($this->getMethod(), $this->getUrl(), $this->getOptions());

        return $client->send($guzzleRequest);
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     *
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * The body option is used to control the body of an entity enclosing request (e.g., PUT, POST, PATCH).
     *
     * @param mixed $body
     *
     * @return $this
     */
    public function setBody($body)
    {
        $this->options['body'] = $body;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        if (isset($this->options['body'])) {
            return $this->options['body'];
        }

        return null;
    }

    /**
     * @param mixed $xml
     *
     * @return $this
     */
    public function setXML($xml)
    {
        $this->options['body'] = $xml;
        $this->addHeader('Content-Type', 'text/xml; charset=utf-8');

        return $this;
    }

    /**
     * Associative array of headers to add to the request.
     * Each key is the name of a header, and each value is a string or array of strings representing the header field values.
     *
     * @param array $headers array of headers
     *
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->options['headers'] = $headers;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getHeaders()
    {
        if (isset($this->options['headers'])) {
            return $this->options['headers'];
        }

        return null;
    }

    /**
     * @param $key
     *
     * @return null
     */
    public function getHeader($key)
    {
        if (isset($this->options['headers'][$key])) {
            return $this->options['headers'][$key];
        }

        return null;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function addHeader($name, $value)
    {
        $this->options['headers'][$name] = $value;

        return $this;
    }


    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set custom array of guzzle request options.
     * This action override all current actions in the request.
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }


    /**
     * Specify the path to a file containing a private SSL key in PEM format.
     *
     * @param string $certificateFile
     * @param null   $password
     */
    public function setSSLKey($certificateFile, $password = null)
    {
        if ($password) {
            $this->options['ssl_key'] = [$certificateFile, $password];
        } else {
            $this->options['ssl_key'] = $certificateFile;
        }
    }

    /**
     * Set to a string to specify the path to a file containing a PEM formatted client side certificate
     *
     * @param string $certificateFile
     * @param null   $password
     */
    public function setCertificate($certificateFile, $password = null)
    {
        if ($password) {
            $this->options['cert'] = [$certificateFile, $password];
        } else {
            $this->options['cert'] = $certificateFile;
        }
    }

    /**
     * @param $curlConstant
     * @param $value
     *
     * @return $this
     */
    public function setCurlOption($curlConstant, $value)
    {
        $this->options['config']['curl'][$curlConstant] = $value;

        return $this;
    }

    /**
     * Query string parameters
     *
     * @param array $query
     *
     * @return $this
     */
    public function setQuery(array $query)
    {
        $this->options['query'] = $query;

        return $this;
    }

    /**
     * Add Query string parameter
     *
     * @param string $param
     * @param mixed  $value
     *
     * @return $this
     */
    public function addQuery($param, $value)
    {
        $this->options['query'][$param] = $value;

        return $this;
    }

    /**
     * Specifies whether or not cookies are used in a request or what cookie jar to use or what cookies to send.
     *
     * @param CookieJarInterface $cookies
     *
     * @return $this
     */
    public function setCookies(CookieJarInterface $cookies)
    {
        $this->options['cookies'] = $cookies;

        return $this;
    }

    /**
     * Set to true or set to a PHP stream returned by fopen() to enable debug output with the handler used to send a request.
     * For example, when using cURL to transfer requests, cURL's verbose of CURLOPT_VERBOSE will be emitted.
     * When using the PHP stream wrapper, stream wrapper notifications will be emitted.
     * If set to true, the output is written to PHP's STDOUT. If a PHP stream is provided, output is written to the stream.
     *
     * @param bool $bool
     *
     * @return $this
     */
    public function setDebug($bool)
    {
        $this->options['debug'] = $bool;

        return $this;
    }

    /**
     * Specify whether or not Content-Encoding responses (gzip, deflate, etc.) are automatically decoded.
     *
     * This option can be used to control how content-encoded response bodies are handled.
     * By default, decode_content is set to true, meaning any gzipped or deflated response will be decoded by Guzzle.
     *
     * When set to false, the body of a response is never decoded, meaning the bytes pass through the handler unchanged.
     *
     * @param string|bool $option
     *
     * @return $this
     */
    public function setDecodeContent($option)
    {
        $this->options['decode_content'] = $option;

        return $this;
    }

    /**
     * Controls the behavior of the "Expect: 100-Continue" header.
     *
     * Set to true to enable the "Expect: 100-Continue" header for all requests that sends a body.
     * Set to false to disable the "Expect: 100-Continue" header for all requests.
     * Set to a number so that the size of the payload must be greater than the number in order to send the Expect header.
     * Setting to a number will send the Expect header for all requests in which the size
     * of the payload cannot be determined or where the body is not rewindable.
     *
     * By default, Guzzle will add the "Expect: 100-Continue" header when the size of the body
     * of a request is greater than 1 MB and a request is using HTTP/1.1.
     *
     * This option only takes effect when using HTTP/1.1.
     * The HTTP/1.0 and HTTP/2.0 protocols do not support the "Expect: 100-Continue" header.
     * Support for handling the "Expect: 100-Continue" workflow
     * must be implemented by Guzzle HTTP handlers used by a client.
     *
     * @param float|integer $option
     *
     * @return $this
     */
    public function setExpect($option)
    {
        $this->options['expect'] = $option;

        return $this;
    }

    /**
     * Used to send an application/x-www-form-urlencoded POST request.
     *
     * Associative array of form field names to values where each value is a string or array of strings.
     * Sets the Content-Type header to application/x-www-form-urlencoded when no Content-Type header is already present.
     *
     * @param array $option
     *
     * @return $this
     */
    public function setFormParams($option)
    {
        $this->options['body'] = $option;
        if (!$this->getHeader('Content-Type')) {
            $this->addHeader('Content-Type', 'application/x-www-form-urlencoded');
        }

        return $this;
    }

    /**
     * Float describing the number of seconds to wait while trying to connect to a server.
     * Use 0 to wait indefinitely (the default behavior).
     *
     * @param float $option
     *
     * @return $this
     */
    public function setConnectTimeOut($option)
    {
        $this->options['connect_timeout'] = $option;

        return $this;
    }

    /**
     * Float describing the timeout of the request in seconds. Use 0 to wait indefinitely (the default behavior).
     *
     * @param float $option
     *
     * @return $this
     */
    public function setTimeOut($option)
    {
        $this->options['timeout'] = $option;

        return $this;
    }

    /**
     * Set to false to disable throwing exceptions on an HTTP protocol errors (i.e., 4xx and 5xx responses).
     * Exceptions are thrown by default when HTTP protocol errors are encountered.
     *
     * @param bool $option
     *
     * @return $this
     */
    public function setHttpErrors($option)
    {
        $this->options['exceptions'] = $option;

        return $this;
    }

    /**
     * The json option is used to easily upload JSON encoded data as the body of a request.
     * A Content-Type header of application/json will be added if no Content-Type header is already present on the message.
     *
     * @param mixed $option Any PHP type that can be operated on by PHP's json_encode() function.
     *
     * @return $this
     */
    public function setJson($option)
    {
        $this->options['json'] = $option;

        return $this;
    }

    /**
     * Protocol version to use with the request.
     *
     * @param $option
     *
     * @return $this
     */
    public function setVersion($option)
    {
        $this->options['version'] = $option;

        return $this;
    }


    /**
     * Describes the redirect behavior of a request
     * Set to false to disable redirects.
     *
     * You can also pass an associative array containing the following key value pairs:
     *
     * - max: (int, default=5) maximum number of allowed redirects.
     * - strict: (bool, default=false) Set to true to use strict redirects.
     *  Strict RFC compliant redirects mean that POST redirect requests are sent as POST requests vs.
     *  doing what most browsers do which is redirect POST requests with GET requests.
     * - referer: (bool, default=true) Set to false to disable adding the Referer header when redirecting.
     * - protocols: (array, default=['http', 'https']) Specified which protocols are allowed for redirect requests.
     *
     * @param bool|array $option
     *
     * @return $this
     */
    public function allowRedirects($option)
    {
        $this->options['allow_redirects'] = $option;

        return $this;
    }

    /**
     * Set to true to stream a response rather than download it all up-front.
     *
     * Streaming response support must be implemented by the HTTP handler used by a client.
     * This option might not be supported by every HTTP handler, but the interface of the response
     * object remains the same regardless of whether or not it is supported by the handler.
     *
     * @param bool $option
     *
     * @return $this
     */
    public function setStream($option)
    {
        $this->options['stream'] = $option;

        return $this;
    }

    /**
     * Set to true to enable SSL certificate validation (the default),
     * false to disable SSL certificate validation,
     * or supply the path to a CA bundle to enable verification using a custom certificate.
     *
     * @param bool|string $option
     *
     * @return $this
     */
    public function SSLVerification($option)
    {
        $this->options['verify'] = $option;

        return $this;
    }

    /**
     * The save_to option specifies where the body of a response is downloaded.
     * You can pass the path to a file, an fopen resource, or a Guzzle\Http\EntityBodyInterface object.
     *
     * @param mixed $option
     *
     * @return $this
     */
    public function saveTo($option)
    {
        $this->options['save_to'] = $option;

        return $this;
    }

    /**
     * Array of event subscribers to add to the request.
     * Each value in the array must be an instance of GuzzleHttp\Event\SubscriberInterface
     *
     * @param array $subscribers
     *
     * @return $this
     */
    public function setSubscribers(array $subscribers)
    {
        $this->options['subscribers'] = $subscribers;

        return $this;
    }

    /**
     * The events option makes it easy to attach listeners to the various events emitted by a request object
     *
     * Available events:
     * - before
     * - complete
     * - error
     * - progress
     * - end
     *
     * @param string   $event    name of the event listen
     * @param callable $closure  function to execute
     * @param int      $priority event priority
     * @param bool     $once     event should be triggered more than once.
     *
     * @return $this
     */
    public function attachEventListener($event, $closure, $priority = null, $once = true)
    {
        if ($priority || !$once) {
            $closure = [
                'fn' => $closure,
                'priority' => $priority,
                'once' => $once,
            ];
        }

        $this->options['events'][$event][] = $closure;

        return $this;
    }


    /**
     * Specify an HTTP proxy
     *
     * Guzzle will automatically populate this value with your environment's NO_PROXY environment variable.
     * However, when providing a proxy request option, it is up to your to provide the no value parsed from
     * the NO_PROXY environment variable (e.g., explode(',', getenv('NO_PROXY'))).
     *
     * @param string  $host IP or name of the host,
     *                      alternatively can set all params in the host
     *                      (e.g. http://username:password@192.168.16.1:10)
     * @param integer $port
     * @param string  $username
     * @param string  $password
     *
     * @return $this
     */
    public function setProxy($host, $port = null, $username = null, $password = null)
    {
        $proxy = $host;
        if ($port || ($username && $password)) {
            if ($username && $password) {
                $proxy = "http://$username:$password@$host:$port";
            } else {
                $proxy = "http://$host:$port";
            }
        }
        $this->options['proxy'] = $proxy;

        return $this;
    }

    /**
     * Specifies HTTP authorization parameters to use with the request
     *
     * This is currently only supported when using the cURL handler.
     *
     * @param string $username
     * @param string $password
     * @param string $type authentication type: "basic" (default), "digest"
     *
     * @return $this
     */
    public function setAuth($username, $password, $type = 'basic')
    {
        $this->options['auth'] = [$username, $password, $type];

        return $this;
    }
}