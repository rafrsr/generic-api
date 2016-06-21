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
     * @param string|object          $class   class to create a valid response object
     * @param DeserializationContext $context context
     */
    public function __construct($class = null, DeserializationContext $context = null)
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

            $parsedResponse = SerializerBuilder::create()->build()
                ->deserialize($content, $this->class, $format, $this->context);

            return $parsedResponse;
        } else {
            return null;
        }
    }
}