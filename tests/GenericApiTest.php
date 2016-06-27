<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\GenericApi\Tests;

use GuzzleHttp\Psr7\Response;
use Rafrsr\GenericApi\ApiInterface;
use Rafrsr\GenericApi\ApiRequestBuilder;
use Rafrsr\GenericApi\GenericApi;
use Rafrsr\GenericApi\GenericApiMock;
use Rafrsr\GenericApi\GenericApiService;

/**
 * Class GenericApiMockTest
 */
class GenericApiTest extends \PHPUnit_Framework_TestCase
{

    public function testMode()
    {
        $api = new GenericApi(ApiInterface::MODE_MOCK);
        static::assertTrue($api->isModeMock());
        $api->setMode(ApiInterface::MODE_SANDBOX);
        static::assertTrue($api->isModeSandBox());
        $api->setMode(ApiInterface::MODE_LIVE);
        static::assertTrue($api->isModeLive());
    }

    public function testGenericApi()
    {
        $api = new GenericApi(ApiInterface::MODE_MOCK); //can use MODE_LIVE

        $mockCallback = function () {
            return new Response(200, [], file_get_contents(__DIR__ . '/../sample/Fixtures/post1.json'));
        };

        $request = ApiRequestBuilder::create()
            ->withMethod('get')
            ->withUri('http://jsonplaceholder.typicode.com/posts/1')
            ->withMock(new GenericApiMock($mockCallback))
            ->getRequest();

        $service = new GenericApiService($request);
        $response = $api->process($service);

        static::assertEquals('200', $response->getStatusCode());
        static::assertEquals(1, json_decode($response->getBody()->getContents(), true)['id']);
    }
}
