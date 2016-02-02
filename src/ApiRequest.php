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

use GuzzleHttp\Psr7\Request;
use Rafrsr\GenericApi\Client\RequestOptions;

/**
 * Class GenericRequest
 */
class ApiRequest extends Request implements ApiRequestInterface
{

    /**
     * @var ApiMockInterface|null
     */
    private $mock;

    /**
     * @var RequestOptions
     */
    private $options;

    /**
     * @return ApiMockInterface|null
     */
    public function getMock()
    {
        return $this->mock;
    }

    /**
     * Set the mock to use to emulate responses
     *
     * @param ApiMockInterface $mock
     *
     * @return $this
     */
    public function withMock(ApiMockInterface $mock)
    {
        $this->mock = $mock;

        return $this;
    }

    /**
     * @return RequestOptions
     */
    public function getOptions()
    {
        if (!$this->options) {
            $this->options = new RequestOptions();
        }

        return $this->options;
    }

    /**
     * @param array|RequestOptions $options
     *
     * @return $this
     */
    public function withOptions($options)
    {
        if (is_array($options)) {
            $options = new RequestOptions($options);
        }

        $this->options = $options;

        return $this;
    }
}
