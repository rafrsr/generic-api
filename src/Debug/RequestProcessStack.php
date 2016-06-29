<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\GenericApi\Debug;

class RequestProcessStack implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @var array|RequestProcess[]
     */
    protected $stack;

    /**
     * @param array|RequestProcess[] $requests
     */
    public function __construct(array $requests = [])
    {
        $this->stack = $requests;
    }

    public function count()
    {
        return count($this->stack);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->stack);
    }

    public function offsetExists($offset)
    {
        return isset($this->stack[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->stack[$offset]) ? $this->stack[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->stack[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->stack[$offset]);
    }
}