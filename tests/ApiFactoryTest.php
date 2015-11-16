<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\GenericApi\Tests;

use Toplib\GenericApi\ApiFactory;
use Toplib\GenericApi\GenericApiMock;

class ApiFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateRequest()
    {
        $method = 'get';
        $url = 'http://example.org';
        $body = '{"id":1}';
        $headers = ['header' => 'type'];
        $mock = new GenericApiMock(
            function () {
            }
        );
        $request = ApiFactory::createRequest($method, $url, $body, $headers, $mock);

        $this->assertInstanceOf('Toplib\GenericApi\ApiRequest', $request);
        $this->assertEquals($method, $request->getMethod());
        $this->assertEquals($url, $request->getUrl());
        $this->assertEquals($body, $request->getBody());
        $this->assertEquals($headers, $request->getHeaders());
        $this->assertEquals($mock, $request->getMock());
    }

    public function testCreateResponse()
    {
        $body = '{"id":1}';
        $response = ApiFactory::createResponse($body, 200, [], []);

        $this->assertInstanceOf('GuzzleHttp\Message\Response', $response);
        $this->assertEquals($body, $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }
}
