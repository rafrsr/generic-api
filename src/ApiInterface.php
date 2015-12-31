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

use Psr\Http\Message\ResponseInterface;
use Toplib\GenericApi\Exception\ApiException;

/**
 * Interface ApiInterface
 */
interface ApiInterface
{
    const MODE_LIVE = 'LIVE'; //production mode in a live server
    const MODE_SANDBOX = 'SANDBOX'; //developer mode in a real test server
    const MODE_MOCK = 'MOCK'; // emulated request/response using mock objects

    /**
     * one of the ApiInterface constant modes
     *
     * @return string
     */
    public function getMode();

    /**
     * @return bool
     */
    public function isModeSandBox();

    /**
     * @return bool
     */
    public function isModeMock();

    /**
     * @return bool
     */
    public function isModeLive();

    /**
     * Process a api service and get the http response
     *
     * @param ApiServiceInterface $service
     *
     * @return ResponseInterface|mixed
     * @throws ApiException if any other kind of error is happened before or after the request is sent
     */
    public function process(ApiServiceInterface $service);
}
