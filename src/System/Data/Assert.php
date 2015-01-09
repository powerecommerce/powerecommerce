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
     * Class Assert
     * @package PowerEcommerce\System\Data
     */
    class Assert extends Object
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
         * @param mixed $value [, $value2, ...]
         * @return bool
         */
        function equals(...$value)
        {
            foreach ($this->value as $item1)
                foreach ($value as $item2) if ($item1 != $item2) return false;
            return true;
        }

        /**
         * @param mixed $value [, $value2, ...]
         * @return bool
         */
        function greaterThan(...$value)
        {
            foreach ($this->value as $item1)
                foreach ($value as $item2) if ($item1 <= $item2) return false;
            return true;
        }

        /**
         * @param mixed $value [, $value2, ...]
         * @return bool
         */
        function greaterThanOrEqual(...$value)
        {
            foreach ($this->value as $item1)
                foreach ($value as $item2) if ($item1 < $item2) return false;
            return true;
        }

        /**
         * @param mixed $value [, $value2, ...]
         * @return bool
         */
        function instance(...$value)
        {
            foreach ($this->value as $item1)
                foreach ($value as $item2) if (!($item1 instanceof $item2)) return false;
            return true;
        }

        /**
         * @param mixed $value [, $value2, ...]
         * @return bool
         */
        function lessThan(...$value)
        {
            foreach ($this->value as $item1)
                foreach ($value as $item2) if ($item1 >= $item2) return false;
            return true;
        }

        /**
         * @param mixed $value [, $value2, ...]
         * @return bool
         */
        function lessThanOrEqual(...$value)
        {
            foreach ($this->value as $item1)
                foreach ($value as $item2) if ($item1 > $item2) return false;
            return true;
        }

        /**
         * @param mixed $value
         * @return bool
         */
        function same($value)
        {
            foreach ($this->value as $item) if ($item !== $value) return false;
            return true;
        }

        /**
         * @return int TypeCode
         */
        function getTypeCode()
        {
            return TypeCode::ASSERT;
        }
    }
}
