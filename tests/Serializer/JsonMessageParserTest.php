<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\GenericApi\Tests\Serializer;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Rafrsr\GenericApi\Serializer\JsonMessageParser;
use Rafrsr\SampleApi\Model\Post;

class JsonMessageParserTest extends TestCase
{
    public function testParseNative()
    {
        $message = '{"id":1,"title":"lorem"}';
        $request = new Request('get', '/', [], $message);

        $parser = new JsonMessageParser();
        $array = $parser->parse($request);
        static::assertEquals(json_decode($message), $array);
    }

    public function testParseSerializer()
    {
        $message = '{"id":1,"title":"lorem"}';
        $request = new Request('get', '/', [], $message);

        /** @var Post $post */
        $parser = new JsonMessageParser(new Post());
        $post = $parser->parse($request);
        static::assertEquals(1, $post->getId());
        static::assertEquals('lorem', $post->getTitle());
    }
}
