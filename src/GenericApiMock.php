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

/**
 * Class GenericApiMock
 */
final class GenericApiMock implements ApiMockInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * GenericApiMock constructor.
     *
     * @param callable $callback function to execute when the request is send,
     *                           accept GuzzleHttp\Message\RequestInterface as the first argument
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @inheritDoc
     */
    public function mock(RequestInterface $request)
    {
        return call_user_func($this->callback, $request);
    }
}