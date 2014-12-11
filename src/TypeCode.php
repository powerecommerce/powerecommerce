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
    abstract class TypeCode
    {
        /**
         * A null reference.
         */
        const BLANK = 123;

        /**
         * True or false.
         */
        const BOOLEAN = 623;

        /**
         * Unsigned 8-bit integers with values between 0 and 255.
         */
        const BYTE = 673;

        /**
         * Unsigned 16-bit integers with values between 0 and 65535.
         */
        const CHAR = 693;

        /**
         * A type representing a array value.
         */
        const CONTAINER = 683;

        /**
         * A type representing a date and time value.
         */
        const DATE_TIME = 283;

        /**
         * A simple type representing values ranging from 1.0 x 10 ^ -28 to approximately 7.9 x 10 ^ 28 with 28-29 significant digits.
         */
        const DECIMAL = 483;

        /**
         * A floating point type representing values ranging from approximately 5.0 x 10 ^ -324 to 1.7 x 10 ^ 308 with a precision of 15-16 digits.
         */
        const DOUBLE = 583;

        /**
         * Signed 16-bit integers with values between -32768 and 32767.
         */
        const INT16 = 783;

        /**
         * Signed 32-bit integers with values between -2147483648 and 2147483647.
         */
        const INT32 = 793;

        /**
         * Signed 64-bit integers with values between -9223372036854775808 and 9223372036854775807.
         */
        const INT64 = 796;

        /**
         * A general type.
         */
        const OBJECT = 999;

        /**
         * Signed 8-bit integers with values between -128 and 127.
         */
        const SBYTE = 456;

        /**
         * A floating point type representing values ranging from approximately 1.5 x 10 ^ -45 to 3.4 x 10 ^ 38 with a precision of 7 digits.
         */
        const SINGLE = 556;

        /**
         * Unicode character strings.
         */
        const STRING = 312;

        /**
         * Represents a time zone.
         */
        const TIME_ZONE = 212;

        /**
         * Unsigned 16-bit integers with values between 0 and 65535.
         */
        const UINT16 = 183;

        /**
         * Unsigned 32-bit integers with values between 0 and 4294967295.
         */
        const UINT32 = 293;

        /**
         * Unsigned 64-bit integers with values between 0 and 18446744073709551615.
         */
        const UINT64 = 396;
    }
}
