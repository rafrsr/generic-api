<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\SampleApi\Services\CreatePost;

use Guzzle\Http\QueryString;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerBuilder;
use Psr\Http\Message\RequestInterface;
use Rafrsr\GenericApi\ApiMockInterface;
use Rafrsr\SampleApi\Model\Post;

/**
 * Class CreatePostMock
 */
class CreatePostMock implements ApiMockInterface
{
    /**
     * @inheritDoc
     */
    public function mock(RequestInterface $request)
    {
        $body = $request->getBody()->getContents();
        parse_str($body, $bodyArray);
        $post = new Post();
        $post->setId(101);
        $post->setTitle($bodyArray['title']);
        $post->setUserId($bodyArray['userId']);
        $post->setBody($bodyArray['body']);

        return new Response(200, [], SerializerBuilder::create()->build()->serialize($post, 'json'));
    }
}
