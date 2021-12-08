<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\GenericApi\Tests;

use PHPUnit\Framework\TestCase;
use Rafrsr\GenericApi\ApiRequest;
use Rafrsr\GenericApi\Client\RequestOptions;
use Rafrsr\SampleApi\Services\GetPost\GetPostMock;

class ApiRequestTest extends TestCase
{

    /**
     * @var ApiRequest
     */
    protected $request;

    public function setUp():void
    {
        $this->request = new ApiRequest('GET', 'http://api.example.org');
    }

    public function testWithMock()
    {
        $this->request->withMock(new GetPostMock());
        static::assertInstanceOf(GetPostMock::class, $this->request->getMock());
    }

    public function testWithOptions()
    {
        static::assertInstanceOf(RequestOptions::class, $this->request->getOptions());

        $this->request->withOptions(['debug' => true]);
        static::assertInstanceOf(RequestOptions::class, $this->request->getOptions());

        $options = new RequestOptions(['debug' => true]);
        $this->request->withOptions($options);

        static::assertEquals($options, $this->request->getOptions());
    }
}
