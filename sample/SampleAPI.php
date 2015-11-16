<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\SampleApi;

use Toplib\GenericApi\GenericApi;
use Toplib\SampleApi\Services\PostsServices;

/**
 * Class SampleAPI
 */
class SampleAPI extends GenericApi
{
    /**
     * posts
     *
     * @return PostsServices
     */
    public function posts()
    {
        return new PostsServices($this);
    }
}