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
         * @var mixed[]
         */
        private $_value = [];

        /**
         * @param mixed $value [, $value2, ...]
         * @exception \InvalidArgumentException
         */
        function __construct(...$value)
        {
            if (!sizeof($value)) $this->invalid();
            $this->_value = $value;
        }

        /**
         * @param string $funcName
         * @return bool
         */
        private function _is($funcName)
        {
            $valid = true;
            foreach ($this->_value as $value) $valid = $valid && $funcName($value);
            return $valid;
        }

        /**
         * @return bool
         */
        function isArray()
        {
            return $this->_is('is_array');
        }

        /**
         * @return bool
         */
        function isBool()
        {
            return $this->_is('is_bool');
        }

        /**
         * @return bool
         */
        function isCallable()
        {
            return $this->_is('is_callable');
        }

        /**
         * @return bool
         */
        function isDouble()
        {
            return $this->_is('is_double');
        }

        /**
         * @return bool
         */
        function isFloat()
        {
            return $this->_is('is_float');
        }

        /**
         * @return bool
         */
        function isInt()
        {
            return $this->_is('is_int');
        }

        /**
         * @return bool
         */
        function isInteger()
        {
            return $this->_is('is_integer');
        }

        /**
         * @return bool
         */
        function isLong()
        {
            return $this->_is('is_long');
        }

        /**
         * @return bool
         */
        function isNull()
        {
            $valid = true;
            foreach ($this->_value as $value) $valid = $valid && (null === $value);
            return $valid;
        }

        /**
         * @return bool
         */
        function isNumeric()
        {
            return $this->_is('is_numeric');
        }

        /**
         * @return bool
         */
        function isObject()
        {
            return $this->_is('is_object');
        }

        /**
         * @return bool
         */
        function isReal()
        {
            return $this->_is('is_real');
        }

        /**
         * @return bool
         */
        function isResource()
        {
            return $this->_is('is_resource');
        }

        /**
         * @return bool
         */
        function isScalar()
        {
            return $this->_is('is_scalar');
        }

        /**
         * @return bool
         */
        function isString()
        {
            return $this->_is('is_string');
        }

        /**
         * @return bool
         */
        function isNumber()
        {
            return $this->_is('is_numeric');
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
         * @param string $className
         * @return bool
         */
        private function _of($className)
        {
            $className = "\\PowerEcommerce\\System\\$className";
            $valid = true;
            foreach ($this->_value as $value) $valid = $valid && ($value instanceof $className);
            return $valid;
        }

        /**
         * @return bool
         */
        function ofBlank()
        {
            return $this->_of('Blank');
        }

        /**
         * @return bool
         */
        function ofCollection()
        {
            return $this->_of('Collection');
        }

        /**
         * @return bool
         */
        function ofContainer()
        {
            return $this->_of('Container');
        }

        /**
         * @return bool
         */
        function ofDateTime()
        {
            return $this->_of('DateTime');
        }

        /**
         * @return bool
         */
        function ofNumber()
        {
            return $this->_of('Number');
        }

        /**
         * @return bool
         */
        function ofObject()
        {
            return $this->_of('Object');
        }

        /**
         * @return bool
         */
        function ofString()
        {
            return $this->_of('String');
        }

        /**
         * @return bool
         */
        function ofTimeZone()
        {
            return $this->_of('TimeZone');
        }

        /**
         * @param int $flags
         * @return bool
         */
        function of($flags)
        {
            if (($flags & TypeCode::BLANK) && $this->ofBlank()) return true;
            if (($flags & TypeCode::COLLECTION) && $this->ofCollection()) return true;
            if (($flags & TypeCode::CONTAINER) && $this->ofContainer()) return true;
            if (($flags & TypeCode::DATETIME) && $this->ofDateTime()) return true;
            if (($flags & TypeCode::NUMBER) && $this->ofNumber()) return true;
            if (($flags & TypeCode::OBJECT) && $this->ofObject()) return true;
            if (($flags & TypeCode::STRING) && $this->ofString()) return true;
            if (($flags & TypeCode::TIMEZONE) && $this->ofTimeZone()) return true;

            return false;
        }

        /**
         * @param int $flags
         * @return bool
         */
        function isof($flags)
        {
            if ($this->is($flags)) return true;
            if ($this->of($flags)) return true;

            return false;
        }

        /**
         * @param int $flags
         * @return true|\InvalidArgumentException
         */
        function strict($flags)
        {
            if ($this->isof($flags)) return true;
            return $this->invalid();
        }

        /**
         * @param mixed $value
         * @return bool
         */
        function assertEquals($value)
        {
            $valid = true;
            foreach ($this->_value as $_value) $valid = $valid && ($_value == $value);
            return $valid;
        }

        /**
         * @param mixed $value
         * @return bool
         */
        function assertGreaterThan($value)
        {
            $valid = true;
            foreach ($this->_value as $_value) $valid = $valid && ($_value > $value);
            return $valid;
        }

        /**
         * @param mixed $value
         * @return bool
         */
        function assertGreaterThanOrEqual($value)
        {
            $valid = true;
            foreach ($this->_value as $_value) $valid = $valid && ($_value >= $value);
            return $valid;
        }

        /**
         * @param mixed $value
         * @return bool
         */
        function assertInstanceOf($value)
        {
            $valid = true;
            foreach ($this->_value as $_value) $valid = $valid && ($_value instanceof $value);
            return $valid;
        }

        /**
         * @param mixed $value
         * @return bool
         */
        function assertLessThan($value)
        {
            $valid = true;
            foreach ($this->_value as $_value) $valid = $valid && ($_value < $value);
            return $valid;
        }

        /**
         * @param mixed $value
         * @return bool
         */
        function assertLessThanOrEqual($value)
        {
            $valid = true;
            foreach ($this->_value as $_value) $valid = $valid && ($_value <= $value);
            return $valid;
        }

        /**
         * @param mixed $value
         * @return bool
         */
        function assertSame($value)
        {
            $valid = true;
            foreach ($this->_value as $_value) $valid = $valid && ($_value === $value);
            return $valid;
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
