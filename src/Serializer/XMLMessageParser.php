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
 * Class XMLMessageParser
 */
class XMLMessageParser extends AbstractSerializerMessageParser
{
    protected $removeNamespacePrefixes;

    /**
     * @param string|object          $class                   class to create a valid response object
     * @param DeserializationContext $context                 context
     * @param boolean                $removeNamespacePrefixes remove all namespaces prefixes before deserialize
     */
    public function __construct($class = null, DeserializationContext $context = null, $removeNamespacePrefixes = false)
    {
        parent::__construct($class, $context);
        $this->removeNamespacePrefixes = $removeNamespacePrefixes;
    }

    /**
     * @inheritdoc
     */
    public function parse(MessageInterface $message)
    {
        $content = $message->getBody()->getContents();
        if ($this->removeNamespacePrefixes) {
            $content = preg_replace('/(<\/?)(\w+:)/', '$1', $content);
        }

        if ($this->class) {
            $parsedResponse = SerializerBuilder::create()->build()
                ->deserialize($content, $this->class, 'xml', $this->context);
        } else {
            $parsedResponse = simplexml_load_string($content);
        }

        return $parsedResponse;
    }
}