<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\GenericApi\Serializer;

use Psr\Http\Message\MessageInterface;

/**
 * MessageParserInterface
 */
interface MessageParserInterface
{
    /**
     * @param MessageInterface $message
     *
     * @return mixed
     */
    public function parse(MessageInterface $message);
}