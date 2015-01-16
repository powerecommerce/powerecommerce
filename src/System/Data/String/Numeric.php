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

namespace PowerEcommerce\System\Data\String {
    use PowerEcommerce\System\Data\String;

    /**
     * Class Numeric
     * @package PowerEcommerce\System\Data\String
     */
    class Numeric extends String
    {
        /**
         * @param string|\PowerEcommerce\System\Object $value
         */
        function __construct($value = null)
        {
            null === $value && $value = $this->_default();
            parent::__construct($value);
        }

        /**
         * @param string|\PowerEcommerce\System\Object $value Numeric values only
         * @return $this
         */
        function setValue($value)
        {
            $value = $value->factory($value);
            !$value->isNumeric() && $value->invalid('Numeric values only');

            return parent::setValue($value->getValue());
        }

        /**
         * @return integer
         */
        protected function _default()
        {
            return '0';
        }
    }
}