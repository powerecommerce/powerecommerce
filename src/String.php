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
     * Class String
     *
     * Unicode character strings.
     *
     * @package PowerEcommerce\System
     */
    class String extends Object
    {
        /**
         * @var string
         */
        protected $value = '';

        /**
         * @param string|\PowerEcommerce\System\String $value
         */
        function __construct($value = '')
        {
            $this->setValue($value);
        }

        /**
         * @param string|\PowerEcommerce\System\String $value
         * @return $this
         */
        function setValue($value)
        {
            $arg = new Argument($value);

            if ($arg->isString()) {
                return $this->_setValue($value);
            }

            if (!$arg->ofString()) {
                return $arg->invalid();
            }

            switch ($value->getTypeCode()) {
                case TypeCode::STRING:
                    return $this->_setValue($value);

                default:
                    return $arg->invalid();
            }
        }

        /**
         * @param string $value
         * @return $this
         */
        private function _setValue($value)
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
         * @param string|\PowerEcommerce\System\String $value
         * @param bool $strict
         * @return bool
         */
        function compare($value, $strict = true)
        {
            $arg = new Argument($value);
            $value = $this->_value($arg, $value);

            switch ($value->getTypeCode()) {
                case TypeCode::STRING:
                    if ($strict) {
                        return 0 === strcmp($this, $value) ? true : false;
                    }
                    return 0 === strcasecmp($this, $value) ? true : false;

                default:
                    return $arg->invalid();
            }
        }

        /**
         * @param \PowerEcommerce\System\Argument $arg
         * @param string|\PowerEcommerce\System\String $value
         * @return \PowerEcommerce\System\String
         */
        private function _value(Argument $arg, $value)
        {
            if ($arg->isString()) {
                return new String($value);
            }

            if (!$arg->ofString()) {
                return $arg->invalid();
            }

            return $value;
        }

        /**
         * @param string|\PowerEcommerce\System\String $value
         * @return $this
         */
        function concat($value)
        {
            $arg = new Argument($value);
            $value = $this->_value($arg, $value);

            switch ($value->getTypeCode()) {
                case TypeCode::STRING:
                    $this->setValue($this . $value);
                    break;

                default:
                    return $arg->invalid();
            }
            return $this;
        }

        /**
         * @param string|\PowerEcommerce\System\String $value
         * @param bool $strict
         * @return bool
         */
        function contains($value, $strict = true)
        {
            $arg = new Argument($value);
            $value = $this->_value($arg, $value);

            switch ($value->getTypeCode()) {
                case TypeCode::STRING:
                    if ($strict) {
                        return false === strpos($this->getValue(), $value->getValue()) ? false : true;
                    }
                    return false === stripos($this->getValue(), $value->getValue()) ? false : true;

                default:
                    return $arg->invalid();
            }
        }

        /**
         * @param int $type \PowerEcommerce\System\TypeCode
         * @return mixed
         */
        function format($type)
        {
            $arg = new Argument($type);

            switch ($type) {
                case TypeCode::STRING:
                    return $this;

                default:
                    return $arg->invalid();
            }
        }

        /**
         * @return int TypeCode
         */
        function getTypeCode()
        {
            return TypeCode::STRING;
        }

        /**
         * @param string[]|\PowerEcommerce\System\String[] $value
         * @return $this
         */
        function join(array $value)
        {
            foreach ($value as $item) {
                $this->concat($item);
            }
            return $this;
        }

        /**
         * @param int $start
         * @param int|null $length
         * @return string
         */
        function substring($start, $length = null)
        {
            return substr($this, $start, $length);
        }

        /**
         * @param int|null $keepStart
         * @param int|null $keepLength
         * @return $this
         */
        function truncate($keepStart = null, $keepLength = null)
        {
            if (null === $keepStart) {
                return $this->setValue('');
            }
            return $this->setValue($this->substring($keepStart, $keepLength));
        }
    }
}
