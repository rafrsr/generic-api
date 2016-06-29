<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\GenericApi\Event;

use Rafrsr\GenericApi\ApiInterface;
use Rafrsr\GenericApi\ApiServiceInterface;
use Symfony\Component\EventDispatcher\Event;

abstract class ApiEvent extends Event
{
    /**
     * @var ApiInterface
     */
    protected $api;

    /**
     * @var ApiServiceInterface
     */
    protected $service;

    /**
     * ApiEvent constructor.
     *
     * @param ApiInterface        $api
     * @param ApiServiceInterface $service
     */
    public function __construct(ApiInterface $api, ApiServiceInterface $service)
    {
        $this->api = $api;
        $this->service = $service;
    }

    /**
     * @return ApiInterface
     */
    public function getApi()
    {
        return $this->api;
    }

      /**
     * @return ApiServiceInterface
     */
    public function getService()
    {
        return $this->service;
    }
}