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
    use PowerEcommerce\System\Data\Integer;

    /**
     * Class Object
     * @package PowerEcommerce\System
     */
    class Object
    {
        /**
         * @var mixed
         */
        protected $value;

        /**
         * @param mixed $value
         */
        function __construct($value = null)
        {
            $this->setValue($value);
        }

        /**
         * @return mixed
         */
        function getValue()
        {
            return $this->value;
        }

        /**
         * @param mixed $value
         * @return $this
         */
        function setValue($value)
        {
            $this->value = $value;
            return $this;
        }

        /**
         * @return string
         */
        function getHashCode()
        {
            return spl_object_hash($this);
        }

        /**
         * @return boolean
         */
        function isArray()
        {
            return $this->_is('array');
        }

        /**
         * @return boolean
         */
        function isBool()
        {
            return $this->_is('bool');
        }

        /**
         * @return boolean
         */
        function isBoolean()
        {
            return $this->_is('bool');
        }

        /**
         * @return boolean
         */
        function isCallable()
        {
            return $this->_is('callable');
        }

        /**
         * @return boolean
         */
        function isDouble()
        {
            return $this->_is('double');
        }

        /**
         * @return boolean
         */
        function isFloat()
        {
            return $this->_is('float');
        }

        /**
         * @return boolean
         */
        function isInt()
        {
            return $this->_is('int');
        }

        /**
         * @return boolean
         */
        function isInteger()
        {
            return $this->_is('integer');
        }

        /**
         * @return boolean
         */
        function isLong()
        {
            return $this->_is('long');
        }

        /**
         * @return boolean
         */
        function isNull()
        {
            return $this->_is('null');
        }

        /**
         * @return boolean
         */
        function isNumeric()
        {
            return $this->_is('numeric');
        }

        /**
         * @return boolean
         */
        function isObject()
        {
            return $this->_is('object');
        }

        /**
         * @return boolean
         */
        function isReal()
        {
            return $this->_is('real');
        }

        /**
         * @return boolean
         */
        function isResource()
        {
            return $this->_is('resource');
        }

        /**
         * @return boolean
         */
        function isScalar()
        {
            return $this->_is('scalar');
        }

        /**
         * @return boolean
         */
        function isString()
        {
            return $this->_is('string');
        }

        /**
         * @return boolean
         */
        function isNumber()
        {
            return $this->_is('numeric');
        }

        /**
         * @return integer
         */
        function length()
        {
            return strlen($this->toString());
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
         * @param mixed $value
         * @return $this
         */
        function defaults($value)
        {
            $this->_default() === $this->getValue() && $this->setValue($value);
            return $this;
        }

        /**
         * @return null
         */
        protected function _default()
        {
            return null;
        }

        /**
         * @param mixed $value
         * @return $this|\PowerEcommerce\System\Object
         */
        function factory($value = '__clone__')
        {
            if ('__clone__' === $value) return (clone $this);
            if (null === $value) return new Object();
            if ($value instanceof \PowerEcommerce\System\Object) return $value;

            return new Object($value);
        }

        /**
         * @param \PowerEcommerce\System\Object $object
         * @return \PowerEcommerce\System\Object
         */
        function cast(Object $object)
        {
            if ($this->getValue() instanceof \PowerEcommerce\System\Object) {
                return $object->setValue($this->getValue());
            }
            return $object->setValue($this->toString());
        }

        /**
         * @return $this
         */
        function clear()
        {
            return $this->setValue($this->_default());
        }

        /**
         * @return string
         */
        function __toString()
        {
            return (string)$this->getValue();
        }

        /**
         * @return string
         */
        function toString()
        {
            return $this->__toString();
        }

        /**
         * @param string $funcName
         * @param mixed $value
         * @return boolean
         */
        protected function _is($funcName, $value = null)
        {
            null === $value && $value = $this->getValue();
            $funcName = 'is_' . $funcName;

            if (!$funcName($value)) return false;
            return true;
        }
    }
}