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

use Psr\Http\Message\MessageInterface;

/**
 * Class CallbackMessageParser
 */
class CallbackMessageParser implements MessageParserInterface
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @inheritDoc
     */
    public function parse(MessageInterface $message)
    {
        return call_user_func($this->callback, $message);
    }
}