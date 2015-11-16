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

use GuzzleHttp\Event\BeforeEvent;
use GuzzleHttp\Event\CompleteEvent;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\RequestFsm;
use GuzzleHttp\Transaction;
use Toplib\GenericApi\ApiMockInterface;

/**
 * Adapter to use with Guzzle client to fake connection to the api using ApiMockInterface.
 * This adapter easily mock the HTTP layer without needing to send requests over the internet.
 * This adapter connect to a mock class and call the method mock()
 * with the request as first argument.
 * The response of the fake method should be Response object with similar body to the original api response.
 */
class MockAdapter extends RequestFsm
{
    /**
     * @var ApiMockInterface
     */
    private $mock;

    /**
     * @param ApiMockInterface $mock
     */
    public function setApiServiceMock(ApiMockInterface $mock)
    {
        $this->mock = $mock;
    }

    /**
     * @param Transaction $trans
     *
     * @return \GuzzleHttp\Message\Response|ResponseInterface|null
     * @throws \Exception
     */
    public function __invoke(Transaction $trans)
    {
        $trans->request->getEmitter()->emit('before', new BeforeEvent($trans));
        if ($response = $trans->response) {
            return $response;
        }

        $response = $this->mock->mock($trans->request);
        if (!$response instanceof ResponseInterface) {
            throw new \Exception('Invalid mock response');
        }

        $trans->response = $response;
        $trans->request->getEmitter()->emit('complete', new CompleteEvent($trans));

        return $trans->response;
    }
}