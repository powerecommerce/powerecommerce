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
    use PowerEcommerce\System\Data\Integer\Round;
    use PowerEcommerce\System\Data\String\Pattern;
    use PowerEcommerce\System\Object;

    /**
     * Class Integer
     * @package PowerEcommerce\System\Data
     */
    class Integer extends Object
    {
        /**
         * @var \GMP
         */
        protected $value;

        /**
         * @param integer|string|\PowerEcommerce\System\Object $value
         */
        function __construct($value = null)
        {
            null === $value && $value = $this->_default();
            parent::__construct($value);
        }

        /**
         * @param integer|string|\PowerEcommerce\System\Object $value
         * @return $this
         */
        function setValue($value)
        {
            $value = $this->factory($value);

            !$value->isInteger()
            && !$value->isString()
            && !($value->getValue() instanceof \GMP)
            && $value->invalid('Integer or string values only');

            !(new String((string)$value))
                ->match(new Pattern('/^[0-9\-]+$/'))
                ->isTrue()
            && $value->invalid('String is not an integer');

            if ($value->getValue() instanceof \GMP) {
                return parent::setValue($value->getValue());
            }
            return parent::setValue(gmp_init($value->getValue()));
        }

        /**
         * @param integer|string|\PowerEcommerce\System\Object $value
         * @return $this
         */
        function defaults($value)
        {
            $this->_default() === $this->toString() && $this->setValue($value);
            return $this;
        }

        /**
         * @return string
         */
        protected function _default()
        {
            return '0';
        }

        /**
         * @param \PowerEcommerce\System\Data\Integer $value
         * @return $this
         */
        function add(Integer $value)
        {
            $this->setValue($this->getValue() + $value->getValue());
            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Data\Integer $value
         * @param \PowerEcommerce\System\Data\Integer\Round $round
         * @return $this
         */
        function divide(Integer $value, Round $round = null)
        {
            if (null === $round) {
                $this->setValue($this->getValue() / $value->getValue());
            } else {
                $this->setValue(gmp_div_q($this->getValue(), $value->getValue(), $round->toString()));
            }
            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Data\Integer $value
         * @return $this
         */
        function modulo(Integer $value)
        {
            $this->setValue($this->getValue() % $value->getValue());
            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Data\Integer $value
         * @return $this
         */
        function multiply(Integer $value)
        {
            $this->setValue($this->getValue() * $value->getValue());
            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Data\Integer $value
         * @return $this
         */
        function subtract(Integer $value)
        {
            $this->setValue($this->getValue() - $value->getValue());
            return $this;
        }

        /**
         * @return $this
         */
        function increment()
        {
            return $this->add(new Integer(1));
        }

        /**
         * @return $this
         */
        function decrement()
        {
            return $this->subtract(new Integer(1));
        }
    }
}