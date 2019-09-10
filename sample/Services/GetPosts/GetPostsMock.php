<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\SampleApi\Services\GetPosts;

use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerBuilder;
use Psr\Http\Message\RequestInterface;
use Rafrsr\GenericApi\ApiMockInterface;
use Rafrsr\GenericApi\Serializer\JsonMessageParser;
use Rafrsr\SampleApi\Model\Post;

/**
 * Class GetPostsMock
 */
class GetPostsMock implements ApiMockInterface
{
    /**
     * @inheritDoc
     */
    public function mock(RequestInterface $request)
    {
        $json = file_get_contents(__DIR__ . '/../../Fixtures/posts.json');
        $parsedQuery = \GuzzleHttp\Psr7\parse_query($request->getUri()->getQuery());

        $response = new Response(200, [], $json);

        //filter
        if (isset($parsedQuery['userId'])) {
            /** @var Post[] $posts */
            $posts = (new JsonMessageParser('array<Rafrsr\SampleApi\Model\Post>'))->parse($response);
            $filteredPosts = [];
            foreach ($posts as $post) {
                if ($post->getUserId() == $parsedQuery['userId']) {
                    $filteredPosts[] = $post;
                }
            }

            $response = new Response(200, [], SerializerBuilder::create()->build()->serialize($filteredPosts, 'json'));
        }

        return $response;
    }
}
