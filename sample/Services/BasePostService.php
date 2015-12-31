<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\SampleApi\Services;

use Toplib\GenericApi\ApiServiceInterface;

/**
 * Class BasePostService
 */
abstract class BasePostService implements ApiServiceInterface
{
    protected $baseUrl = 'http://jsonplaceholder.typicode.com';

    protected function buildServiceUrl($relativeUrl, $parameters = [])
    {
        return $this->baseUrl . vsprintf($relativeUrl, $parameters);
    }
}