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

    /**
     * Class Boolean
     * @package PowerEcommerce\System\Data
     */
    class Boolean extends Object
    {
        /**
         * @param boolean|\PowerEcommerce\System\Object $value Boolean values only
         * @return $this
         */
        function setValue($value)
        {
            $value = $this->factory($value);
            !$value->isBoolean() && $value->invalid('Boolean values only');

            return parent::setValue($value->getValue());
        }

        /**
         * @return $this
         */
        function clear()
        {
            return $this->invalid();
        }

        /**
         * @return boolean
         */
        function isTrue()
        {
            return $this->getValue() === true;
        }

        /**
         * @return boolean
         */
        function isFalse()
        {
            return $this->getValue() === false;
        }
    }
}