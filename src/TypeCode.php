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
     * Class TypeCode
     * @package PowerEcommerce\System
     */
    class TypeCode
    {
        /**
         * A null reference.
         */
        const BLANK = 1;

        /**
         * A type representing a Dependency Injection Container.
         */
        const CONTAINER = 1 << 1;

        /**
         * A type representing a date and time value.
         */
        const DATETIME = 1 << 2;

        /**
         * A type representing a number value.
         */
        const NUMBER = 1 << 3;

        /**
         * A general type.
         */
        const OBJECT = 1 << 4;

        /**
         * Unicode character strings.
         */
        const STRING = 1 << 5;

        /**
         * Represents a time zone.
         */
        const TIMEZONE = 1 << 6;

        /**
         * Php
         */
        const PHP_ARRAY = 1 << 7;
        const PHP_BOOL = 1 << 8;
        const PHP_CALLABLE = 1 << 9;
        const PHP_DOUBLE = 1 << 10;
        const PHP_FLOAT = 1 << 11;
        const PHP_INT = 1 << 12;
        const PHP_INTEGER = 1 << 13;
        const PHP_LONG = 1 << 14;
        const PHP_NULL = 1 << 15;
        const PHP_NUMERIC = 1 << 16;
        const PHP_OBJECT = 1 << 17;
        const PHP_REAL = 1 << 18;
        const PHP_RESOURCE = 1 << 19;
        const PHP_SCALAR = 1 << 20;
        const PHP_STRING = 1 << 21;

        /**
         * @var int
         */
        private static $_flags = 0;

        private function __construct()
        {
        }

        /**
         * @return int
         */
        static function getFlags()
        {
            if (0 !== self::$_flags) return self::$_flags;

            $reflector = new \ReflectionClass('\PowerEcommerce\System\TypeCode');
            $all = $reflector->getConstants();

            foreach ($all as $const) self::$_flags |= $const;
            return self::$_flags;
        }
    }
}
