<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\SampleApi\Services\CreatePost;

use GuzzleHttp\Message\RequestInterface;
use JMS\Serializer\SerializerBuilder;
use Toplib\GenericApi\ApiFactory;
use Toplib\GenericApi\ApiMockInterface;
use Toplib\GenericApi\Serializer\JsonMessageParser;
use Toplib\SampleApi\Model\Post;

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
        /** @var Post $post */
        $post = (new JsonMessageParser('Toplib\SampleApi\Model\Post'))->parse($request);
        $post->setId(101);

        return ApiFactory::createResponse(SerializerBuilder::create()->build()->serialize($post, 'json'));
    }
}