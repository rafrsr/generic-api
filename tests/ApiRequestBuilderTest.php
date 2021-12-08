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
use Rafrsr\GenericApi\ApiRequestBuilder;
use Rafrsr\SampleApi\Model\Post;
use Rafrsr\SampleApi\Services\GetPost\GetPostMock;

class ApiRequestBuilderTest extends TestCase
{
    /**
     * @var ApiRequestBuilder
     */
    protected $rb;

    public function setUp(): void
    {
        $this->rb = new ApiRequestBuilder();
    }

    public function testStaticCreate()
    {
        $rb = ApiRequestBuilder::create();
        static::assertInstanceOf(ApiRequestBuilder::class, $rb);
    }

    public function testWithMethod()
    {
        $this->rb->withMethod('GET');
        static::assertEquals('GET', $this->rb->getMethod());
    }

    public function testWithUri()
    {
        $this->rb->withUri('http://api.example.org');
        static::assertEquals('http://api.example.org', $this->rb->getUri());
    }

    public function testWithBody()
    {
        $this->rb->withBody('{"test":1}');
        static::assertEquals('{"test":1}', $this->rb->getBody());
    }

    public function testWithHeaders()
    {
        $this->rb->withHeaders(['foo' => 'bar']);
        static::assertEquals(['foo' => 'bar'], $this->rb->getHeaders());
    }

    public function testAddHeaders()
    {
        $this->rb->addHeader('foo', 'bar');
        $this->rb->addHeader('foo2', 'bar2');
        static::assertEquals(['foo' => 'bar', 'foo2' => 'bar2'], $this->rb->getHeaders());
    }

    public function testWithProtocol()
    {
        $this->rb->withProtocol('1.0');
        static::assertEquals('1.0', $this->rb->getProtocol());
    }

    public function testWithMock()
    {
        $this->rb->withMock(GetPostMock::class);
        static::assertInstanceOf(GetPostMock::class, $this->rb->getMock());
    }

    public function testWithJsonBody()
    {
        $post = new Post();
        $post->setId(1);
        $post->setTitle('title');
        $post->setBody('body');
        $post->setUserId(1);
        $this->rb->withJsonBody($post);
        static::assertEquals('{"userId":1,"id":1,"title":"title","body":"body"}', $this->rb->getBody());
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

        static::assertEquals($xml, $this->rb->getBody());
    }
}
