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

use Psr\Http\Message\RequestInterface;
use Toplib\GenericApi\Client\RequestOptions;

/**
 * Interface ApiRequestInterface
 *
 * This interface is used to generate a valid guzzle http request
 */
interface ApiRequestInterface extends RequestInterface
{

    /**
     * @return ApiMockInterface
     */
    public function getMock();

    /**
     * Set the mock to use to emulate responses
     *
     * @param ApiMockInterface|null $mock
     *
     * @return $this
     */
    public function withMock(ApiMockInterface $mock);

    /**
     * @return RequestOptions
     */
    public function getOptions();

    /**
     * Options to use with guzzle when send the request
     *
     * @param array|RequestOptions $options
     *
     * @return $this
     */
    public function withOptions($options);
}
