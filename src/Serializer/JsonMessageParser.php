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
 * Class JsonMessageParser
 */
class JsonMessageParser extends AbstractSerializerMessageParser
{
    /**
     * @inheritdoc
     */
    public function parse(MessageInterface $message)
    {
        if ($deserialized = $this->deserialize($message, 'json')) {
            return $deserialized;
        } else {
            return json_decode($message->getBody()->getContents());
        }
    }
}