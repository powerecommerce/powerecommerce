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
     * Class Object
     *
     * A general type.
     *
     * @package PowerEcommerce\System
     */
    abstract class Object
    {
        protected $value;

        /**
         * @param mixed $value
         */
        function __construct($value)
        {
            $this->value = $value;
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
         */
        function setValue($value)
        {
            $this->value = $value;
        }

        /**
         * @param \PowerEcommerce\System\Object $object
         * @return bool
         */
        abstract function compare(Object $object);

        /**
         * @param \PowerEcommerce\System\Object $object
         * @return \PowerEcommerce\System\Object
         */
        abstract function concat(Object $object);

        /**
         * @param \PowerEcommerce\System\Object $object
         * @return bool
         */
        abstract function contains(Object $object);

        /**
         * @param int $type \PowerEcommerce\System\TypeCode
         * @return mixed
         */
        abstract function format($type);

        /**
         * @return string
         */
        function getHashCode()
        {
            return spl_object_hash($this);
        }

        /**
         * @return int TypeCode
         */
        abstract function getTypeCode();

        /**
         * @param \PowerEcommerce\System\Object[] $object
         * @return \PowerEcommerce\System\Object
         */
        abstract function join(array $object);

        /**
         * @param \PowerEcommerce\System\Object $object
         * @return bool
         */
        abstract function same(Object $object);
    }
}
