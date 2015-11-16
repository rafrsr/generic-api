<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\SampleApi\Services\GetPosts;

use GuzzleHttp\Message\RequestInterface;
use JMS\Serializer\SerializerBuilder;
use Toplib\GenericApi\ApiFactory;
use Toplib\GenericApi\ApiMockInterface;
use Toplib\GenericApi\Serializer\JsonMessageParser;
use Toplib\SampleApi\Model\Post;

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
        $userId = $request->getQuery()->get('userId');

        $response = ApiFactory::createResponse($json);

        //filter
        if ($userId) {
            /** @var Post[] $posts */
            $posts = (new JsonMessageParser('array<Toplib\SampleApi\Model\Post>'))->parse($response);
            $filteredPosts = [];
            foreach ($posts as $post) {
                if ($post->getUserId() == $userId) {
                    $filteredPosts[] = $post;
                }
            }

            $response = ApiFactory::createResponse(SerializerBuilder::create()->build()->serialize($filteredPosts, 'json'));
        }


        return $response;
    }
}