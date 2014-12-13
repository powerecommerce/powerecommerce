<?php

/**
 * Copyright (c) 2015 DD Art Tomasz Duda
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace PowerEcommerce\System {

    /**
     * Class Argument
     * @package PowerEcommerce\System
     */
    class Argument
    {
        /**
         * @var mixed
         */
        private $_value;

        /**
         * @param mixed $value
         */
        function __construct($value)
        {
            $this->_value = $value;
        }

        /**
         * @return bool
         */
        function isNull()
        {
            return (null === $this->_value);
        }

        /**
         * @return bool
         */
        function isString()
        {
            return is_string($this->_value);
        }

        /**
         * @return bool
         */
        function isNumber()
        {
            return is_numeric($this->_value);
        }

        /**
         * @return bool
         */
        function ofBlank()
        {
            return $this->_value instanceof Blank;
        }

        /**
         * @return bool
         */
        function ofContainer()
        {
            return $this->_value instanceof Container;
        }

        /**
         * @return bool
         */
        function ofDateTime()
        {
            return $this->_value instanceof DateTime;
        }

        /**
         * @return bool
         */
        function ofNumber()
        {
            return $this->_value instanceof Number;
        }

        /**
         * @return bool
         */
        function ofObject()
        {
            return $this->_value instanceof Object;
        }

        /**
         * @return bool
         */
        function ofString()
        {
            return $this->_value instanceof String;
        }

        /**
         * @return bool
         */
        function ofTimeZone()
        {
            return $this->_value instanceof TimeZone;
        }

        /**
         * @param string $message
         * @return \InvalidArgumentException
         */
        function invalid($message = null)
        {
            throw new \InvalidArgumentException($message);
        }
    }
}
