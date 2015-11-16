<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\SampleApi\Services;

use Toplib\SampleApi\Model\Post;
use Toplib\SampleApi\Services\CreatePost\CreatePost;
use Toplib\SampleApi\Services\DeletePost\DeletePost;
use Toplib\SampleApi\Services\GetPost\GetPost;
use Toplib\SampleApi\Services\GetPosts\GetPosts;
use Toplib\SampleApi\Services\UpdatePost\UpdatePost;

/**
 * Class PostsServices
 */
class PostsServices
{

    /**
     * @var \Toplib\GenericApi\ApiInterface
     */
    protected $api;

    /**
     * PostsServices constructor.
     *
     * @param $api
     */
    public function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * getPosts
     *
     * @param integer $userId filter by userId
     *
     * @return array|Post[]
     */
    public function getList($userId = null)
    {
        return $this->api->process(new GetPosts($userId));
    }

    /**
     * Example using a service class
     *
     * @param $id
     *
     * @return Post
     * @throws \Toplib\GenericApi\Exception\ApiException
     */
    public function get($id)
    {
        return $this->api->process(new GetPost($id));
    }

    /**
     * Create new post
     *
     * @param Post $post
     *
     * @return Post
     */
    public function create(Post $post)
    {
        return $this->api->process(new CreatePost($post));
    }

    /**
     * Update post
     *
     * @param Post $post
     *
     * @return Post
     */
    public function update(Post $post)
    {
        return $this->api->process(new UpdatePost($post));
    }

    /**
     * Delete a Post
     *
     * @param Post $post
     *
     * @return bool
     */
    public function delete(Post $post)
    {
        $response = $this->api->process(new DeletePost($post));
        if ($response->getStatusCode() == 200) {
            return true;
        } else {
            return false;
        }
    }
}