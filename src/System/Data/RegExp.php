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
    use PowerEcommerce\System\Object;
    use PowerEcommerce\System\TypeCode;

    /**
     * Class RegExp
     * @package PowerEcommerce\System\Data
     */
    class RegExp extends Object
    {
        /**
         * @var string
         */
        protected $value = '';

        /**
         * @param string|\PowerEcommerce\System\Object $value
         */
        function __construct($value = '')
        {
            $this->setValue($value);
        }

        /**
         * @param string|\PowerEcommerce\System\Object $value
         * @return $this
         */
        function setValue($value)
        {
            $arg = new Argument($value);

            if ($arg->isString()) return $this->_set($value);
            $arg->strict(TypeCode::OBJECT);

            switch ($value->getTypeCode()) {
                case TypeCode::COLLECTION:
                case TypeCode::DATETIME:
                case TypeCode::NUMBER:
                case TypeCode::STRING:
                case TypeCode::TIMEZONE:

                case TypeCode::ACL:
                case TypeCode::PRIVILEGE:
                case TypeCode::RESOURCE:
                case TypeCode::ROLE:
                    return $this->_set($value);

                default:
                    return $this->_set('');
            }
        }

        /**
         * @param string $value
         * @return $this
         */
        private function _set($value)
        {
            $this->value = (string)$value;
            return $this;
        }

        /**
         * @return string
         */
        public function getValue()
        {
            return $this->value;
        }

        /**
         * @return string
         */
        function __toString()
        {
            return $this->getValue();
        }

        /**
         * @return int TypeCode
         */
        function getTypeCode()
        {
            return TypeCode::REGEXP;
        }

        /**
         * @param string|\PowerEcommerce\System\String $value
         * @param array $output
         * @param int $flags
         * @param int $offset
         * @return int
         */
        function match($value, array &$output = [], $flags = 0, $offset = 0)
        {
            (new Argument($value))->strict(TypeCode::PHP_STRING | TypeCode::STRING);
            return preg_match($this->getValue(), $value, $output, $flags, $offset);
        }
    }
}
