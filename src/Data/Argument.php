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

namespace PowerEcommerce\System\Data {
    use PowerEcommerce\System\TypeCode;

    /**
     * Class Argument
     * @package PowerEcommerce\System\Data
     */
    class Argument extends Assert
    {
        /**
         * @var mixed[]
         */
        protected $value = [];

        /**
         * @param mixed $value [, $value2, ...]
         */
        function __construct(...$value)
        {
            $this->setValue($value);
        }

        /**
         * @return mixed[]
         */
        function getValue()
        {
            return $this->value;
        }

        /**
         * @param mixed[] $value
         */
        function setValue(array $value)
        {
            $this->value = $value;
        }

        /**
         * @param string $funcName
         * @return bool
         */
        private function _is($funcName)
        {
            foreach ($this->value as $value) if (!$funcName($value)) return false;
            return true;
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
            return $this->_is('is_null');
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
         * @param string $namespace
         * @return bool
         */
        private function _of($className, $namespace = '\\PowerEcommerce\\System\\')
        {
            $fullClassName = "$namespace$className";
            foreach ($this->value as $value) if (!($value instanceof $fullClassName)) return false;
            return true;
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
        function ofArgument()
        {
            return $this->_of('Data\\Argument');
        }

        /**
         * @return bool
         */
        function ofAssert()
        {
            return $this->_of('Data\\Assert');
        }

        /**
         * @return bool
         */
        function ofBlank()
        {
            return $this->_of('Data\\Blank');
        }

        /**
         * @return bool
         */
        function ofCollection()
        {
            return $this->_of('Data\\Collection');
        }

        /**
         * @return bool
         */
        function ofDateTime()
        {
            return $this->_of('Data\\DateTime');
        }

        /**
         * @return bool
         */
        function ofNumber()
        {
            return $this->_of('Data\\Number');
        }

        /**
         * @return bool
         */
        function ofString()
        {
            return $this->_of('Data\\String');
        }

        /**
         * @return bool
         */
        function ofTimeZone()
        {
            return $this->_of('Data\\TimeZone');
        }

        /**
         * @return bool
         */
        function ofAcl()
        {
            return $this->_of('Security\\Component\\Acl');
        }

        /**
         * @return bool
         */
        function ofPrivilege()
        {
            return $this->_of('Security\\Component\\Privilege');
        }

        /**
         * @return bool
         */
        function ofResource()
        {
            return $this->_of('Security\\Component\\Resource');
        }

        /**
         * @return bool
         */
        function ofRole()
        {
            return $this->_of('Security\\Component\\Role');
        }

        /**
         * @param int $flags
         * @return bool
         */
        function of($flags)
        {
            if (($flags & TypeCode::OBJECT) && $this->ofObject()) return true;

            if (($flags & TypeCode::ARGUMENT) && $this->ofArgument()) return true;
            if (($flags & TypeCode::ASSERT) && $this->ofAssert()) return true;
            if (($flags & TypeCode::BLANK) && $this->ofBlank()) return true;
            if (($flags & TypeCode::COLLECTION) && $this->ofCollection()) return true;
            if (($flags & TypeCode::DATETIME) && $this->ofDateTime()) return true;
            if (($flags & TypeCode::NUMBER) && $this->ofNumber()) return true;
            if (($flags & TypeCode::STRING) && $this->ofString()) return true;
            if (($flags & TypeCode::TIMEZONE) && $this->ofTimeZone()) return true;

            if (($flags & TypeCode::ACL) && $this->ofAcl()) return true;
            if (($flags & TypeCode::PRIVILEGE) && $this->ofPrivilege()) return true;
            if (($flags & TypeCode::RESOURCE) && $this->ofResource()) return true;
            if (($flags & TypeCode::ROLE) && $this->ofRole()) return true;

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
         * @param string $msg
         * @return \InvalidArgumentException
         */
        function invalid($msg = '')
        {
            throw new \InvalidArgumentException($msg);
        }

        /**
         * @return int TypeCode
         */
        function getTypeCode()
        {
            return TypeCode::ARGUMENT;
        }
    }
}
