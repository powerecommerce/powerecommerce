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
        function isArray()
        {
            return is_array($this->_value);
        }

        /**
         * @return bool
         */
        function isBool()
        {
            return is_bool($this->_value);
        }

        /**
         * @return bool
         */
        function isCallable()
        {
            return is_callable($this->_value);
        }

        /**
         * @return bool
         */
        function isDouble()
        {
            return is_double($this->_value);
        }

        /**
         * @return bool
         */
        function isFloat()
        {
            return is_float($this->_value);
        }

        /**
         * @return bool
         */
        function isInt()
        {
            return is_int($this->_value);
        }

        /**
         * @return bool
         */
        function isInteger()
        {
            return is_integer($this->_value);
        }

        /**
         * @return bool
         */
        function isLong()
        {
            return is_long($this->_value);
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
        function isNumeric()
        {
            return is_numeric($this->_value);
        }

        /**
         * @return bool
         */
        function isObject()
        {
            return is_object($this->_value);
        }

        /**
         * @return bool
         */
        function isReal()
        {
            return is_real($this->_value);
        }

        /**
         * @return bool
         */
        function isResource()
        {
            return is_resource($this->_value);
        }

        /**
         * @return bool
         */
        function isScalar()
        {
            return is_scalar($this->_value);
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
         * @param int $flags
         * @return bool
         */
        function is($flags)
        {
            if (($flags & TypeCode::PHP_ARRAY) && $this->isArray()) return true;
            if (($flags & TypeCode::PHP_BOOL) && $this->isBool()) return true;
            if (($flags & TypeCode::PHP_CALLABLE) && $this->isCallable()) return true;
            if (($flags & TypeCode::PHP_DOUBLE) && $this->isDouble()) return true;
            if (($flags & TypeCode::PHP_FLOAT) && $this->isFloat()) return true;
            if (($flags & TypeCode::PHP_INT) && $this->isInt()) return true;
            if (($flags & TypeCode::PHP_INTEGER) && $this->isInteger()) return true;
            if (($flags & TypeCode::PHP_LONG) && $this->isLong()) return true;
            if (($flags & TypeCode::PHP_NULL) && $this->isNull()) return true;
            if (($flags & TypeCode::PHP_NUMERIC) && $this->isNumeric()) return true;
            if (($flags & TypeCode::PHP_OBJECT) && $this->isObject()) return true;
            if (($flags & TypeCode::PHP_REAL) && $this->isReal()) return true;
            if (($flags & TypeCode::PHP_RESOURCE) && $this->isResource()) return true;
            if (($flags & TypeCode::PHP_SCALAR) && $this->isScalar()) return true;
            if (($flags & TypeCode::PHP_STRING) && $this->isString()) return true;

            return false;
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
         * @param int $flags
         * @return bool
         */
        function of($flags)
        {
            if (($flags & TypeCode::BLANK) && $this->ofBlank()) return true;
            if (($flags & TypeCode::CONTAINER) && $this->ofContainer()) return true;
            if (($flags & TypeCode::DATETIME) && $this->ofDateTime()) return true;
            if (($flags & TypeCode::NUMBER) && $this->ofNumber()) return true;
            if (($flags & TypeCode::OBJECT) && $this->ofObject()) return true;
            if (($flags & TypeCode::STRING) && $this->ofString()) return true;
            if (($flags & TypeCode::TIMEZONE) && $this->ofTimeZone()) return true;

            return false;
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
