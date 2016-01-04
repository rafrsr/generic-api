<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\GenericApi\Tests;

use Toplib\GenericApi\ApiRequest;
use Toplib\GenericApi\Client\RequestOptions;
use Toplib\SampleApi\Services\GetPost\GetPostMock;

class ApiRequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ApiRequest
     */
    protected $request;

    public function setUp()
    {
        $this->request = new ApiRequest('GET', 'http://api.example.org');
    }

    public function testWithMock()
    {
        $this->request->withMock(new GetPostMock());
        $this->assertInstanceOf(GetPostMock::class, $this->request->getMock());
    }

    public function testWithOptions()
    {
        $this->assertInstanceOf(RequestOptions::class, $this->request->getOptions());

        $this->request->withOptions(['debug' => true]);
        $this->assertInstanceOf(RequestOptions::class, $this->request->getOptions());

        $options = new RequestOptions(['debug' => true]);
        $this->request->withOptions($options);

        $this->assertEquals($options, $this->request->getOptions());
    }
}
