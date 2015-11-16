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

use GuzzleHttp\Message\MessageInterface;

/**
 * Class XMLMessageParser
 */
class XMLMessageParser extends AbstractSerializerMessageParser
{

    /**
     * @inheritdoc
     */
    public function parse(MessageInterface $message)
    {
        if ($deserialized = $this->deserialize($message, 'xml')) {
            return $deserialized;
        } else {
            return simplexml_load_string($message->getBody()->getContents());
        }
    }
}