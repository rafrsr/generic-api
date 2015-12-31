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
use Psr\Http\Message\ResponseInterface;

/**
 * Class MockInterface
 */
interface ApiMockInterface
{

    /**
     * Mock HTTP request,
     * analyze the request and emulate a real api response.
     * Helpful for automated or customer tests.
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function mock(RequestInterface $request);
}