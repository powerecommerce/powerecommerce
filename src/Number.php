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
     * Class Number
     *
     * A type representing a number value.
     *
     * @package PowerEcommerce\System
     */
    class Number extends Object
    {
        /**
         * @var string
         */
        protected $amount;

        /**
         * @var int
         */
        protected $precision;

        /**
         * @var int
         */
        protected $round;

        /**
         * @param string|\PowerEcommerce\System\Object $amount
         * @param int|string|\PowerEcommerce\System\Object $precision
         * @param int $round PHP_ROUND_HALF_DOWN|PHP_ROUND_HALF_UP
         */
        function __construct($amount = '', $precision = 4, $round = PHP_ROUND_HALF_UP)
        {
            $this->setAmount($amount);
            $this->setPrecision($precision);
            $this->setRound($round);
        }

        /**
         * @return string
         */
        function getAmount()
        {
            return $this->amount;
        }

        /**
         * @return int
         */
        function getPrecision()
        {
            return $this->precision;
        }

        /**
         * @return int
         */
        function getRound()
        {
            return $this->round;
        }

        /**
         * @return string
         */
        function __toString()
        {
            return $this->getAmount();
        }

        /**
         * @param string|\PowerEcommerce\System\Object $amount
         * @return $this
         */
        function setAmount($amount)
        {
            $set = function ($value) {
                $this->amount = (string)$value;
                return $this;
            };

            $arg = new Argument($amount);

            if ($arg->isString()) {
                return $set($amount);
            }

            $arg->strict(TypeCode::OBJECT);

            switch ($amount->getTypeCode()) {
                case TypeCode::BLANK:
                case TypeCode::OBJECT:
                    return $set('0');

                case TypeCode::COLLECTION:
                case TypeCode::DATETIME:
                case TypeCode::NUMBER:
                case TypeCode::STRING:
                case TypeCode::TIMEZONE:
                    return $set($amount);

                default:
                    return $arg->invalid();
            }
        }

        /**
         * @param int|string|\PowerEcommerce\System\Object $precision
         * @return $this
         */
        function setPrecision($precision)
        {
            $set = function ($value) {
                $this->precision = (int)"$value";
                return $this;
            };

            $arg = new Argument($precision);

            if ($arg->is(TypeCode::PHP_STRING | TypeCode::PHP_INT)) {
                return $set($precision);
            }

            $arg->strict(TypeCode::OBJECT);

            switch ($precision->getTypeCode()) {
                case TypeCode::BLANK:
                case TypeCode::OBJECT:
                    return $set('0');

                case TypeCode::COLLECTION:
                case TypeCode::DATETIME:
                case TypeCode::NUMBER:
                case TypeCode::STRING:
                case TypeCode::TIMEZONE:
                    return $set($precision);

                default:
                    return $arg->invalid();
            }
        }

        /**
         * @param int $round PHP_ROUND_HALF_DOWN|PHP_ROUND_HALF_UP
         * @return $this
         */
        function setRound($round)
        {
            $arg = new Argument($round);
            if ($arg->assertSame(PHP_ROUND_HALF_DOWN) || $arg->assertSame(PHP_ROUND_HALF_UP)) {
                $this->round = $round;
            } else {
                $arg->invalid();
            }
            return $this;
        }

        /**
         * @param string $amount
         * @return string
         */
        private function round($amount)
        {
            $shift = 0;
            $this->getPrecision() == 0 && $shift -= 1;

            return (substr($amount, -1) < 5)
                ? substr($amount, 0, -1 + $shift)
                : substr($amount, 0, -2 + $shift) . ((int)substr($amount, -2 + $shift, -1 + $shift) + 1);
        }

        /**
         * @param string $func
         * @param \PowerEcommerce\System\Number $value
         */
        private function _operation($func, Number $value)
        {
            switch ($this->getRound()) {
                case PHP_ROUND_HALF_UP:
                    $this->amount = $this->round($func($this->getAmount(), $value->getAmount(), $this->getPrecision() + 1));
                    break;

                default:
                    $this->amount = $func($this->getAmount(), $value->getAmount(), $this->getPrecision());
                    break;
            }
        }

        /**
         * @param \PowerEcommerce\System\Number $value
         */
        function add(Number $value)
        {
            $this->_operation('bcadd', $value);
        }

        /**
         * @param \PowerEcommerce\System\Number $value
         */
        function divide(Number $value)
        {
            $this->_operation('bcdiv', $value);
        }

        /**
         * @param \PowerEcommerce\System\Number $value
         */
        function modulo(Number $value)
        {
            $this->_operation('bcmod', $value);
        }

        /**
         * @param \PowerEcommerce\System\Number $value
         */
        function multiply(Number $value)
        {
            $this->_operation('bcmul', $value);
        }

        /**
         * @param \PowerEcommerce\System\Number $value
         */
        function subtract(Number $value)
        {
            $this->_operation('bcsub', $value);
        }

        /**
         * @param int $targets
         * @return \PowerEcommerce\System\Number[]
         */
        function allocate($targets)
        {
            $_targets = clone $this;
            $_targets->setAmount($targets);

            $one = clone $this;
            $one->setAmount('1');

            $part = clone $this;
            $part->divide($_targets);

            $end = clone $this;
            $results = [];

            for ($i = 1; $i < $targets; $i++) {
                $results[] = $part;
                $end->subtract($part);
            }

            $results[] = $end;
            return $results;
        }

        /**
         * @return int TypeCode
         */
        function getTypeCode()
        {
            return TypeCode::NUMBER;
        }
    }
}
