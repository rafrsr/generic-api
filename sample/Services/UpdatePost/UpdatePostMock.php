<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\SampleApi\Services\UpdatePost;

use Guzzle\Http\QueryString;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use Psr\Http\Message\RequestInterface;
use Rafrsr\GenericApi\ApiMockInterface;

/**
 * Class UpdatePostMock
 */
class UpdatePostMock implements ApiMockInterface
{
    /**
     * @inheritDoc
     */
    public function mock(RequestInterface $request)
    {
        $json = file_get_contents(__DIR__.'/../../Fixtures/post1.json');
        $serializer = SerializerBuilder::create()
            ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())
            ->addDefaultHandlers()
            ->addDefaultListeners()
            ->build();
        $post = $serializer->deserialize($json, 'Rafrsr\SampleApi\Model\Post', 'json');
        $body = $request->getBody()->getContents();
        parse_str($body, $bodyArray);
        $post->setTitle($bodyArray['title']);
        $post->setUserId($bodyArray['userId']);
        $post->setBody($bodyArray['body']);

        return new Response(200, [], $serializer->serialize($post, 'json'));
    }
}
