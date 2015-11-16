<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\SampleApi;

use JMS\Serializer\SerializerBuilder;
use Toplib\GenericApi\ApiMockInterface;
use Toplib\GenericApi\ApiRequest;

/**
 * Class SampleAPIRequest
 */
class SampleAPIRequest extends ApiRequest
{
    /**
     * GenericApiRequest constructor.
     *
     * @param string           $method http method to use
     * @param string           $url    url to send the request
     * @param object           $body
     * @param ApiMockInterface $mock   instance of mock to use
     */
    public function __construct($method, $url, $body, $mock = null)
    {
        $url = 'http://jsonplaceholder.typicode.com' . $url;
        parent::__construct($method, $url, [], $mock);

        if ($body) {
            $body = SerializerBuilder::create()->build()->serialize($body, 'json');
            $this->setBody($body);
        }
    }
}