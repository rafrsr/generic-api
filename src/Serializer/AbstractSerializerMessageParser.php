<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\GenericApi\Serializer;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
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
     * @var DeserializationContext
     */
    protected $context;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param string|object          $class      class to create a valid response object
     * @param DeserializationContext $context    context
     * @param SerializerInterface    $serializer use custom serializer
     */
    public function __construct($class = null, DeserializationContext $context = null, SerializerInterface $serializer = null)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }
        $this->class = $class;
        $this->serializer = $serializer;
    }

    /**
     * @inheritdoc
     */
    protected function deserialize(MessageInterface $message, $format)
    {
        if ($this->class) {
            $content = $message->getBody()->getContents();

            $serializer = $this->serializer;
            if (!$serializer) {
                $serializer = SerializerBuilder::create()->build();
            }

            $parsedResponse = $serializer->deserialize($content, $this->class, $format, $this->context);

            return $parsedResponse;
        } else {
            return null;
        }
    }
}