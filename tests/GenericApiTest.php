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

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Rafrsr\GenericApi\ApiInterface;
use Rafrsr\GenericApi\ApiRequestInterface;
use Rafrsr\GenericApi\ApiRequestBuilder;
use Rafrsr\GenericApi\Event\OnResponseEvent;
use Rafrsr\GenericApi\GenericApi;
use Rafrsr\GenericApi\GenericApiMock;
use Rafrsr\GenericApi\GenericApiService;

/**
 * Class GenericApiMockTest
 */
class GenericApiTest extends TestCase
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
            return new Response(200, [], file_get_contents(__DIR__.'/../sample/Fixtures/post1.json'));
        };

        $request = ApiRequestBuilder::create()
                                    ->withMethod('get')
                                    ->withUri('http://jsonplaceholder.typicode.com/posts/1')
                                    ->withMock(new GenericApiMock($mockCallback))
                                    ->getRequest();

        $service = new GenericApiService($request);

        $api->onResponse(
            function (OnResponseEvent $event) {
                self::assertLessThan(1000, $event->getExecutionTime());
            }
        );

        $response = $api->process($service);

        static::assertEquals('200', $response->getStatusCode());
        static::assertEquals(1, json_decode($response->getBody()->getContents(), true)['id']);
    }

    public function testOnResponseEventIsDispatchedWhenConnectionFails()
    {
        $request = ApiRequestBuilder::create()
                                    ->withMethod('get')
                                    ->withUri('http://jsonplaceholder.typicode.com/posts/1')
                                    ->getRequest();

        // ConnectException does not extend RequestException, is the one guzzle throws on timeout, dns or reset
        $connectException = new ConnectException('Connection reset by peer', $request);

        $this->assertOnResponseEventIsDispatchedWithoutResponse($request, $connectException);
    }

    public function testOnResponseEventIsDispatchedWhenRequestFailsWithoutResponse()
    {
        $request = ApiRequestBuilder::create()
                                    ->withMethod('get')
                                    ->withUri('http://jsonplaceholder.typicode.com/posts/1')
                                    ->getRequest();

        $requestException = new RequestException('Error completing request', $request);

        $this->assertOnResponseEventIsDispatchedWithoutResponse($request, $requestException);
    }

    /**
     * @param ApiRequestInterface $request
     * @param \Exception          $sendException exception thrown by sendRequest
     */
    private function assertOnResponseEventIsDispatchedWithoutResponse(ApiRequestInterface $request, \Exception $sendException)
    {
        $api = new class($sendException) extends GenericApi {
            private $sendException;

            public function __construct(\Exception $sendException)
            {
                parent::__construct();
                $this->sendException = $sendException;
            }

            protected function sendRequest(ApiRequestInterface $request)
            {
                throw $this->sendException;
            }
        };

        $service = new GenericApiService($request);

        $dispatchedEvent = null;
        $api->onResponse(
            function (OnResponseEvent $event) use (&$dispatchedEvent) {
                $dispatchedEvent = $event;
            }
        );

        $thrownException = null;
        try {
            $api->process($service);
        } catch (\Exception $e) {
            $thrownException = $e;
        }

        static::assertSame($sendException, $thrownException, 'The exception must be rethrown after dispatching the event');
        static::assertInstanceOf(OnResponseEvent::class, $dispatchedEvent, 'The listener must be executed even without response');
        static::assertNull($dispatchedEvent->getResponse());
        static::assertSame($request, $dispatchedEvent->getRequest());
        static::assertSame($sendException, $dispatchedEvent->getException());
        static::assertSame($service, $dispatchedEvent->getService());
    }
}
