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

use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;
use Psr\Http\Message\StreamInterface;

/**
 * Class RequestOptions
 */
class RequestOptions
{

    /**
     * @var array
     */
    private $options = [];

    /**
     * RequestOptions constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * Create new request options instance
     *
     * RequestOptions::create()->SSLVerification(false);
     *
     * @param array $options
     *
     * @return RequestOptions
     */
    public static function create(array $options = [])
    {
        return new RequestOptions($options);
    }

    /**
     * @return array
     */
    public function getAll()
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
    public function setAll(array $options)
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
            $this->options[GuzzleRequestOptions::SSL_KEY] = [$certificateFile, $password];
        } else {
            $this->options[GuzzleRequestOptions::SSL_KEY] = $certificateFile;
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
            $this->options[GuzzleRequestOptions::CERT] = [$certificateFile, $password];
        } else {
            $this->options[GuzzleRequestOptions::CERT] = $certificateFile;
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
        $this->options['curl'][$curlConstant] = $value;

        return $this;
    }

    /**
     * Associative array of query string values to add
     * to the request. This option uses PHP's http_build_query() to create
     * the string representation. Pass a string value if you need more
     * control than what this method provides
     *
     * @param array|string $query
     *
     * @return $this
     */
    public function setQuery($query)
    {
        $this->options[GuzzleRequestOptions::QUERY] = $query;

        return $this;
    }

    /**
     * The body option is used to control the body of an entity enclosing request (e.g., PUT, POST, PATCH).
     *
     * @param string|StreamInterface $body
     *
     * @return $this
     */
    public function setBody($body)
    {
        $this->options[GuzzleRequestOptions::BODY] = $body;

        return $this;
    }

    /**
     * Associative array of headers to add to the request.
     * Each key is the name of a header, and each value is a string or array of strings representing the header field values.
     *
     * @param array $headers
     *
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->options[GuzzleRequestOptions::HEADERS] = $headers;

        return $this;
    }

    /**
     * Headers to add to the request.
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function addHeader($key, $value)
    {
        $this->options[GuzzleRequestOptions::HEADERS][$key] = $value;

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
        if (!isset($this->options[GuzzleRequestOptions::QUERY])) {
            $this->options[GuzzleRequestOptions::QUERY] = [];
        }

        if (!is_array($this->options[GuzzleRequestOptions::QUERY])) {
            throw  new \LogicException('The query has been set as string and can`t be modified');
        }

        $this->options[GuzzleRequestOptions::QUERY][$param] = $value;

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
        $this->options[GuzzleRequestOptions::COOKIES] = $cookies;

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
        $this->options[GuzzleRequestOptions::DEBUG] = $bool;

        return $this;
    }

    /**
     * Defines a function to invoke when transfer
     * progress is made. The function accepts the following positional
     * arguments: the total number of bytes expected to be downloaded, the
     * number of bytes downloaded so far, the number of bytes expected to be
     * uploaded, the number of bytes uploaded so far.
     *
     * @param callable $option
     *
     * @return $this
     */
    public function setProgress(callable $option)
    {
        $this->options[GuzzleRequestOptions::PROGRESS] = $option;

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
        $this->options[GuzzleRequestOptions::DECODE_CONTENT] = $option;

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
        $this->options[GuzzleRequestOptions::EXPECT] = $option;

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
        $this->options[GuzzleRequestOptions::FORM_PARAMS] = $option;

        return $this;
    }

    /**
     * Used to send an application/x-www-form-urlencoded POST request.
     *
     * Add new form param to the list of existent params
     *
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function addFormParam($name, $value)
    {
        $this->options[GuzzleRequestOptions::FORM_PARAMS][$name] = $value;

        return $this;
    }

    /**
     * Sets the body of the request to a multipart/form-data form.
     *
     * The value of multipart is an array of associative arrays, each containing the following key value pairs:
     *
     * name: (string, required) the form field name
     * contents: (StreamInterface/resource/string, required) The data to use in the form element.
     * headers: (array) Optional associative array of custom headers to use with the form element.
     * filename: (string) Optional string to send as the filename in the part.
     *
     * @param array $option
     *
     * @return $this
     */
    public function setMultipart(array $option)
    {
        $this->options[GuzzleRequestOptions::MULTIPART] = $option;

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
        $this->options[GuzzleRequestOptions::CONNECT_TIMEOUT] = $option;

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
        $this->options[GuzzleRequestOptions::TIMEOUT] = $option;

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
        $this->options[GuzzleRequestOptions::HTTP_ERRORS] = $option;

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
        $this->options[GuzzleRequestOptions::JSON] = $option;

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
        $this->options[GuzzleRequestOptions::VERSION] = $option;

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
        $this->options[GuzzleRequestOptions::ALLOW_REDIRECTS] = $option;

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
        $this->options[GuzzleRequestOptions::STREAM] = $option;

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
        $this->options[GuzzleRequestOptions::VERIFY] = $option;

        return $this;
    }

    /**
     * Specify where the body of a response will be saved.
     *
     * @param string|StreamInterface $option
     *
     * @return $this
     */
    public function saveResponseTo($option)
    {
        $this->options[GuzzleRequestOptions::SINK] = $option;

        return $this;
    }

    /**
     * Set to true to inform HTTP handlers that you intend on waiting on the response.
     * This can be useful for optimizations.
     *
     * @param bool $option
     *
     * @return $this
     */
    public function setSynchronous($option)
    {
        $this->options[GuzzleRequestOptions::SYNCHRONOUS] = $option;

        return $this;
    }

    /**
     * The number of milliseconds to delay before sending the request.
     *
     * @param float|integer $option
     *
     * @return $this
     */
    public function setDelay($option)
    {
        $this->options[GuzzleRequestOptions::DELAY] = $option;

        return $this;
    }

    /**
     * A callable that is invoked when the HTTP headers of the response have been
     * received but the body has not yet begun to download.
     *
     * The callable accepts a Psr\Http\ResponseInterface object.
     * If an exception is thrown by the callable, then the promise associated with the response
     * will be rejected with a GuzzleHttp\Exception\RequestException that wraps the exception that was thrown.
     *
     * @param callable $option
     *
     * @return $this
     */
    public function onHeaders(callable $option)
    {
        $this->options[GuzzleRequestOptions::ON_HEADERS] = $option;

        return $this;
    }

    /**
     * Allows you to get access to transfer statistics of a request and access the lower level
     * transfer details of the handler associated with your client.
     * on_stats is a callable that is invoked when a handler has finished sending a request.
     * The callback is invoked with transfer statistics about the request, the response received, or the error encountered.
     * Included in the data is the total amount of time taken to send the request.
     *
     * @param callable $option
     *
     * @return $this
     */
    public function onStats(callable $option)
    {
        $this->options[GuzzleRequestOptions::ON_STATS] = $option;

        return $this;
    }

    /**
     * Pass a string to specify an HTTP proxy, or an array to specify different proxies for different protocols.
     *
     * Pass an associative array to specify HTTP proxies for specific URI schemes (i.e., "http", "https").
     * Provide a no key value pair to provide a list of host names that should not be proxied to.
     *
     * @param string|array $proxy
     *
     * @return $this
     */
    public function setProxy($proxy)
    {
        $this->options[GuzzleRequestOptions::PROXY] = $proxy;

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
        $this->options[GuzzleRequestOptions::AUTH] = [$username, $password, $type];

        return $this;
    }

    /**
     * Set an option manually
     *
     * @param $option
     * @param $value
     */
    public function set($option, $value)
    {
        $this->options[$option] = $value;
    }

    /**
     * Get a option value
     *
     * @param $option
     *
     * @return null
     */
    public function get($option)
    {
        return (isset($this->options[$option]) ? $this->options[$option] : null);
    }
}