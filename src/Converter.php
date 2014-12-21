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
     * Class Converter
     * @package PowerEcommerce\System
     */
    class Converter
    {
        /**
         * @var \PowerEcommerce\System\Object
         */
        protected $object;

        /**
         * @param \PowerEcommerce\System\Object $object
         */
        function __construct(Object $object)
        {
            $this->object = $object;
        }

        /**
         * @param int $typeCode TypeCode
         * @return \PowerEcommerce\System\Object
         */
        function format($typeCode)
        {
            $arg = new Argument($typeCode);
            $arg->strict(TypeCode::PHP_INT);

            return $this->_convert($typeCode);
        }

        /**
         * @param int $typeCode TypeCode
         * @return \PowerEcommerce\System\Object
         */
        private function _convert($typeCode)
        {
            $arg = new Argument($typeCode);

            switch ($typeCode) {
                case TypeCode::BLANK:
                    return new Blank($this->object);

                case TypeCode::OBJECT:
                    return $this->object;

                case TypeCode::COLLECTION:
                    return new Collection($this->object);

                case TypeCode::DATETIME:
                    return new DateTime($this->object);

                case TypeCode::NUMBER:
                    return new Number($this->object);

                case TypeCode::STRING:
                    return new String($this->object);

                case TypeCode::TIMEZONE:
                    return new TimeZone($this->object);

                default:
                    return $arg->invalid();
            }
        }
    }
}
