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

use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Stream\StreamInterface;

/**
 * Class ApiFactory
 */
class ApiFactory
{
    /**
     * Create a new generic API request to send data
     *
     * @param string           $method  http method to use
     * @param string           $url     url to send the request
     * @param string           $body    body of the request
     * @param array            $headers array of headers
     * @param ApiMockInterface $mock    mock to emulate the request
     *
     * @return ApiRequest
     */
    static public function createRequest($method, $url, $body = null, $headers = [], $mock = null)
    {
        $request = new ApiRequest($method, $url);
        $request->setBody($body);
        $request->setHeaders($headers);
        $request->setMock($mock);

        return $request;
    }

    /**
     * Create a valid Guzzle Response
     *
     * @param resource|string|StreamInterface $content    Entity body data
     * @param int|string                      $statusCode The response status code (e.g. 200)
     * @param array                           $headers    The response headers
     * @param array                           $options    Response message options
     *                                                    - reason_phrase: Set a custom reason phrase
     *                                                    - protocol_version: Set a custom protocol version
     *
     * @return Response
     */
    static public function createResponse($content, $statusCode = '200', $headers = [], $options = [])
    {
        return new Response($statusCode, $headers, Stream::factory($content), $options);
    }
}