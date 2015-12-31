<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\GenericApi\Tests\Serializer;

use GuzzleHttp\Psr7\Request;
use Toplib\GenericApi\Serializer\XMLMessageParser;
use Toplib\SampleApi\Model\Post;

class XMLMessageParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseNative()
    {
        $message = '<post><id>1</id><title>lorem</title></post>';
        $request = new Request('get', '/', [], $message);

        $parser = new XMLMessageParser();
        $xml = $parser->parse($request);
        $this->assertEquals(simplexml_load_string($message), $xml);
    }

    public function testParseSerializer()
    {
        $message = '<post><id>1</id><title>lorem</title></post>';
        $request = new Request('get', '/', [], $message);

        /** @var Post $post */
        $parser = new XMLMessageParser(new Post());
        $post = $parser->parse($request);
        $this->assertEquals(1, $post->getId());
        $this->assertEquals('lorem', $post->getTitle());
    }
}
