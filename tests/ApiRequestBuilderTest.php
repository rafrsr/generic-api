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

use Toplib\GenericApi\ApiRequestBuilder;
use Toplib\SampleApi\Model\Post;
use Toplib\SampleApi\Services\GetPost\GetPostMock;

class ApiRequestBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiRequestBuilder
     */
    protected $rb;

    public function setUp()
    {
        $this->rb = new ApiRequestBuilder();
    }

    public function testStaticCreate()
    {
        $rb = ApiRequestBuilder::create();
        $this->assertInstanceOf(ApiRequestBuilder::class, $rb);
    }

    public function testWithMethod()
    {
        $this->rb->withMethod('GET');
        $this->assertEquals('GET', $this->rb->getMethod());
    }

    public function testWithUri()
    {
        $this->rb->withUri('http://api.example.org');
        $this->assertEquals('http://api.example.org', $this->rb->getUri());
    }

    public function testWithBody()
    {
        $this->rb->withBody('{"test":1}');
        $this->assertEquals('{"test":1}', $this->rb->getBody());
    }

    public function testWithHeaders()
    {
        $this->rb->withHeaders(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $this->rb->getHeaders());
    }

    public function testAddHeaders()
    {
        $this->rb->addHeader('foo', 'bar');
        $this->rb->addHeader('foo2', 'bar2');
        $this->assertEquals(['foo' => 'bar', 'foo2' => 'bar2'], $this->rb->getHeaders());
    }

    public function testWithProtocol()
    {
        $this->rb->withProtocol('1.0');
        $this->assertEquals('1.0', $this->rb->getProtocol());
    }

    public function testWithMock()
    {
        $this->rb->withMock(GetPostMock::class);
        $this->assertInstanceOf(GetPostMock::class, $this->rb->getMock());
    }

    public function testWithJsonBody()
    {
        $post = new Post();
        $post->setId(1);
        $post->setTitle('title');
        $post->setBody('body');
        $post->setUserId(1);
        $this->rb->withJsonBody($post);
        $this->assertEquals('{"userId":1,"id":1,"title":"title","body":"body"}', $this->rb->getBody());
    }

    public function testWithXmlBody()
    {
        $post = new Post();
        $post->setId(1);
        $post->setTitle('title');
        $post->setBody('body');
        $post->setUserId(1);
        $this->rb->withXMLBody($post);
        $xml
            = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<result>
  <userId>1</userId>
  <id>1</id>
  <title><![CDATA[title]]></title>
  <body><![CDATA[body]]></body>
</result>

XML;

        $this->assertEquals($xml, $this->rb->getBody());
    }
}
