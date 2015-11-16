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

use Toplib\GenericApi\Client\HttpRequest;

/**
 * Class GenericRequest
 */
class ApiRequest extends HttpRequest implements ApiRequestInterface
{

    /**
     * @var ApiMockInterface|null
     */
    private $mock;

    /**
     * GenericApiRequest constructor.
     *
     * @param string           $method  http method to use
     * @param string           $url     url to send the request
     * @param array            $options array of guzzle request options
     * @param ApiMockInterface $mock    instance of mock to use
     */
    public function __construct($method, $url, $options = [], $mock = null)
    {
        parent::__construct($method, $url, $options);

        $this->mock = $mock;
    }

    /**
     * @return ApiMockInterface|null
     */
    public function getMock()
    {
        return $this->mock;
    }

    /**
     * @param ApiMockInterface|null $mock
     *
     * @return $this
     */
    public function setMock($mock)
    {
        $this->mock = $mock;

        return $this;
    }
}
