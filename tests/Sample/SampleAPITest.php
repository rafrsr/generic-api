<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\GenericApi\Tests\Sample;

use Rafrsr\GenericApi\ApiInterface;
use Rafrsr\SampleApi\Model\Post;
use Rafrsr\SampleApi\SampleAPI;

/**
 * Class SampleAPITest
 */
class SampleAPITest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SampleAPI
     */
    private $api;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->api = new SampleAPI(ApiInterface::MODE_MOCK); //can use MODE_LIVE
    }

    public function testGetPosts()
    {
        $posts = $this->api->posts()->getList();
        static::assertEquals(1, $posts[0]->getId());
        static::assertCount(100, $posts);

        //filter by userId
        $posts = $this->api->posts()->getList(1);
        static::assertCount(10, $posts);
    }

    public function testGetPost()
    {
        $post = $this->api->posts()->get(1);
        static::assertEquals(1, $post->getId());
    }

    public function testUpdatePost()
    {
        $post = $this->api->posts()->get(1);
        $post->setBody('updated');
        $postUpdated = $this->api->posts()->update($post);
        static::assertEquals($post->getBody(), $postUpdated->getBody());
    }

    public function testCreatePost()
    {
        $post = new Post();
        $post->setTitle('optio reprehenderit');
        $post->setBody('facere repellat provident occaecati excepturi optio reprehenderit');
        $post->setUserId('1');
        $postCreated = $this->api->posts()->create($post);
        static::assertEquals(101, $postCreated->getId());
    }

    public function testDeletePost()
    {
        $post = $this->api->posts()->get(1);
        static::assertTrue($this->api->posts()->delete($post));
    }
}
