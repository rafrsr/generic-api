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

use GuzzleHttp\Url;

/**
 * Class HttpRequestInterface
 */
interface HttpRequestInterface
{

    /**
     * Http method to use, GET, POST, PUT ...
     *
     * @return mixed
     */
    public function getMethod();

    /**
     * Url to send the request
     *
     * @return string|Url
     */
    public function getUrl();

    /**
     * Array of options to use with guzzle.
     * review the guzzle doc to view all available options
     *
     * @return array
     */
    public function getOptions();

    /**
     * Send a request
     *
     * @param array $clientConfig
     *
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
     */
    public function send(array $clientConfig = []);
}