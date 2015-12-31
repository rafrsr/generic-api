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

use JMS\Serializer\SerializerBuilder;
use Psr\Http\Message\MessageInterface;

/**
 * Class AbstractSerializerMessageParser
 */
abstract class AbstractSerializerMessageParser implements MessageParserInterface
{

    /**
     * @var string
     */
    protected $class;

    /**
     * @param string|object $class class to create a valid response object
     */
    public function __construct($class = null)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }
        $this->class = $class;
    }

    /**
     * @inheritdoc
     */
    protected function deserialize(MessageInterface $message, $format)
    {
        if ($this->class) {
            $content = $message->getBody()->getContents();

            $parsedResponse = SerializerBuilder::create()->build()->deserialize($content, $this->class, $format);

            return $parsedResponse;
        } else {
            return null;
        }
    }
}