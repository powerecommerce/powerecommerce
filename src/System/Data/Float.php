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
    use PowerEcommerce\System\Data\Float\Round;
    use PowerEcommerce\System\Data\Float\Round\HalfUp;
    use PowerEcommerce\System\Data\String\Pattern;

    /**
     * Class Float
     * @package PowerEcommerce\System\Data
     */
    class Float extends String
    {
        /**
         * @var \PowerEcommerce\System\Data\Integer
         */
        protected $precision;

        /**
         * @var \PowerEcommerce\System\Data\Float\Round
         */
        protected $round;

        /**
         * @param string|\PowerEcommerce\System\Object $value
         * @param \PowerEcommerce\System\Data\Integer $precision
         * @param \PowerEcommerce\System\Data\Float\Round $round
         */
        function __construct($value = null, Integer $precision = null, Round $round = null)
        {
            null === $value && $value = $this->_default();
            null === $precision && $precision = new Integer(4);
            null === $round && $round = new HalfUp();

            parent::__construct($value);
            $this->setPrecision($precision);
            $this->setRound($round);
        }

        /**
         * @return string
         */
        protected function _default()
        {
            return '0.';
        }

        /**
         * @return \PowerEcommerce\System\Data\Integer
         */
        function getPrecision()
        {
            return $this->precision;
        }

        /**
         * @return \PowerEcommerce\System\Data\Float\Round
         */
        function getRound()
        {
            return $this->round;
        }

        /**
         * @param string|\PowerEcommerce\System\Object $value
         * @return $this
         */
        function setValue($value)
        {
            $value = $this->factory($value);
            parent::setValue($value->getValue());

            !(new String($value->toString()))
                ->match(
                    new Pattern('/^[^\.]*\.{1}[^\.]*$/')
                )
                ->isTrue()
            && $value->invalid('String is not an float');

            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Data\Integer $precision
         * @return $this
         */
        function setPrecision(Integer $precision)
        {
            $this->precision = $precision;
            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Data\Float\Round $round
         * @return $this
         */
        function setRound(Round $round)
        {
            $this->round = $round;
            return $this->round();
        }


        /**
         * @param \PowerEcommerce\System\Data\Float $value
         * @return $this
         */
        function add(Float $value)
        {
            return $this->_operation('bcadd', $value);
        }

        /**
         * @param \PowerEcommerce\System\Data\Float $value
         * @return $this
         */
        function divide(Float $value)
        {
            return $this->_operation('bcdiv', $value);
        }

        /**
         * @param \PowerEcommerce\System\Data\Float $value
         * @return $this
         */
        function modulo(Float $value)
        {
            return $this->_operation('bcmod', $value);
        }

        /**
         * @param \PowerEcommerce\System\Data\Float $value
         * @return $this
         */
        function multiply(Float $value)
        {
            return $this->_operation('bcmul', $value);
        }

        /**
         * @param \PowerEcommerce\System\Data\Float $value
         * @return $this
         */
        function subtract(Float $value)
        {
            return $this->_operation('bcsub', $value);
        }

        /**
         * @param \PowerEcommerce\System\Data\Float $targets
         * @return \PowerEcommerce\System\Data\Collection
         */
        function allocate(Float $targets)
        {
            $part = $this->factory()->divide($targets);
            $last = $this->factory();
            $collection = new Collection();

            for ($i = 1; $i < $targets->toString(); $i++) {
                $collection->push($part);
                $last->subtract($part);
            }
            return $collection->push($last);
        }

        /**
         * @return $this
         */
        function increment()
        {
            return $this->add(new Float('1.0'));
        }

        /**
         * @return $this
         */
        function decrement()
        {
            return $this->subtract(new Float('1.0'));
        }

        /**
         * @return $this
         */
        function round()
        {
            $str = new String();
            $collection = $str
                ->factory()
                ->setValue($this->toString())
                ->explode($dot = $str->factory()->setValue('.'));

            $f1 = (string)$collection->current();
            $f2 = (string)$collection->get($str->factory()->setValue('1'));

            if ($str->factory()->setValue($f2)->length() <= $this->getPrecision()->toString()) {
                return $this;
            }

            /** @var \PowerEcommerce\System\Data\Integer $f3 */
            $f3 = $str->factory()->setValue($f2)
                ->substring(
                    $this->getPrecision()->factory()->decrement(),
                    $this->getPrecision()->factory()->setValue(1)
                )->cast(new Integer());

            /** @var \PowerEcommerce\System\Data\Integer $f4 */
            $f4 = $str->factory()->setValue($f2)
                ->substring(
                    $this->getPrecision()->factory(),
                    $this->getPrecision()->factory()->setValue(1)
                )->cast(new Integer());

            if ($this->getRound() instanceof \PowerEcommerce\System\Data\Float\Round\HalfUp) {
                $f4->toString() >= 5 && $f3->increment();
            }

            return $this->setValue(
                $str->factory()->setValue($f1)
                    ->concat($dot)
                    ->concat($str
                        ->factory()->setValue($f2)
                        ->truncate($this->getPrecision()->factory()->decrement())
                    )
                    ->concat($f3->cast($str->factory()))
            );
        }

        /**
         * @param string $func
         * @param \PowerEcommerce\System\Data\Float $value
         * @return $this
         */
        private function _operation($func, Float $value)
        {
            if ($this->getRound() instanceof \PowerEcommerce\System\Data\Float\Round\HalfUp) {
                bcscale(
                    $this->getPrecision()
                        ->factory()
                        ->increment()
                        ->toString()
                );
                $result = new String(
                    $func( //BC Math Function
                        $this->getValue(),
                        $value->getValue()
                    )
                );
            } elseif ($this->getRound() instanceof \PowerEcommerce\System\Data\Float\Round\HalfDown) {
                bcscale(
                    $this->getPrecision()
                        ->toString()
                );
                $result = new String(
                    $func( //BC Math Function
                        $this->getValue(),
                        $value->getValue()
                    )
                );
            }

            'bcmod' === $func && $result->concat(new String('.'));
            return $this->setValue($result)->round();
        }
    }
}