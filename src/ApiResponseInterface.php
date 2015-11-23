<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\GenericApi;

/**
 * Class ApiResponseInterface
 */
interface ApiResponseInterface
{

    /**
     * getRawResponse
     *
     * @return string
     */
    public function getRawResponse();

    /**
     * setRawResponse
     *
     * @param string $raw
     *
     * @return $this
     */
    public function setRawResponse($raw);

    /**
     * isSuccess
     *
     * @return bool
     */
    public function isSuccess();

    /**
     * hasError
     *
     * @return bool
     */
    public function hasError();

    /**
     * getError
     *
     * @return string
     */
    public function getError();
}