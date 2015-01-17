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

namespace PowerEcommerce\System\Util {

    /**
     * Class DataGenerator
     * @package PowerEcommerce\System\Util
     */
    class DataGenerator
    {
        /**
         * @var integer
         */
        static $max = 1000;

        /**
         * @var integer
         */
        const _ARRAY = 1 << 0;

        /**
         * @var integer
         */
        const _BOOLEAN = 1 << 1;

        /**
         * @var integer
         */
        const _FLOAT = 1 << 2;

        /**
         * @var integer
         */
        const _INTEGER = 1 << 3;

        /**
         * @var integer
         */
        const _NULL = 1 << 4;

        /**
         * @var integer
         */
        const _OBJECT = 1 << 5;

        /**
         * @var integer
         */
        const _RESOURCE = 1 << 6;

        /**
         * @var integer
         */
        const _STRING = 1 << 7;

        /**
         * @return \Generator
         */
        static function _boolean()
        {
            yield true;
            yield false;

            for ($i = 0; $i <= self::$max; ++$i) {
                yield mt_rand(0, 1) ? true : false;
            }
        }

        /**
         * @return \Generator
         */
        static function _integer()
        {
            yield -PHP_INT_MAX;
            yield PHP_INT_MAX;

            for ($i = 0; $i <= self::$max; ++$i) {
                yield intval(mt_rand(0, 1)
                    ? mt_rand(-PHP_INT_MAX, mt_getrandmax())
                    : abs(mt_rand(-PHP_INT_MAX, mt_getrandmax())));

                yield intval(mt_rand(0, 1)
                    ? mt_rand(-PHP_INT_MAX / mt_rand(1000, 10000), mt_getrandmax())
                    : abs(mt_rand(-PHP_INT_MAX / mt_rand(1000, 10000), mt_getrandmax())));

                yield intval(mt_rand(0, 1)
                    ? mt_rand(-PHP_INT_MAX / mt_rand(10000, 100000), mt_getrandmax())
                    : abs(mt_rand(-PHP_INT_MAX / mt_rand(10000, 100000), mt_getrandmax())));

                yield intval(mt_rand(0, 1)
                    ? mt_rand(-PHP_INT_MAX / mt_rand(100000000, 1000000000), mt_getrandmax())
                    : abs(mt_rand(-PHP_INT_MAX / mt_rand(100000000, 1000000000), mt_getrandmax())));

                yield intval(mt_rand(0, 1)
                    ? mt_rand(-1000, 1000)
                    : abs(mt_rand(-1000, 1000)));

                yield intval(mt_rand(0, 1)
                    ? mt_rand(-100, 100)
                    : abs(mt_rand(-100, 100)));

                yield intval(mt_rand(0, 1)
                    ? mt_rand(-10, 10)
                    : abs(mt_rand(-10, 10)));

                yield intval(mt_rand(0, 1)
                    ? mt_rand(0, 1000)
                    : abs(mt_rand(0, 1000)));

                yield intval(mt_rand(0, 1)
                    ? mt_rand(-100, 0)
                    : abs(mt_rand(-100, 0)));

                yield intval(mt_rand(0, 1)
                    ? mt_rand(-1000, 0)
                    : abs(mt_rand(-1000, 0)));
            }
        }

        /**
         * @return \Generator
         */
        static function _float()
        {
            yield floatval(-PHP_INT_MAX);
            yield floatval(PHP_INT_MAX);

            for ($i = 0; $i <= self::$max; ++$i) {
                yield floatval(mt_rand(0, 1)
                    ? mt_rand(-PHP_INT_MAX, mt_getrandmax())
                    : abs(mt_rand(-PHP_INT_MAX, mt_getrandmax())));

                yield floatval(mt_rand(0, 1)
                    ? mt_rand(-PHP_INT_MAX / mt_rand(1000, 10000), mt_getrandmax())
                    : abs(mt_rand(-PHP_INT_MAX / mt_rand(1000, 10000), mt_getrandmax())));

                yield floatval(mt_rand(0, 1)
                    ? mt_rand(-PHP_INT_MAX / mt_rand(10000, 100000), mt_getrandmax())
                    : abs(mt_rand(-PHP_INT_MAX / mt_rand(10000, 100000), mt_getrandmax())));

                yield floatval(mt_rand(0, 1)
                    ? mt_rand(-PHP_INT_MAX / mt_rand(100000000, 1000000000), mt_getrandmax())
                    : abs(mt_rand(-PHP_INT_MAX / mt_rand(100000000, 1000000000), mt_getrandmax())));

                yield floatval(mt_rand(0, 1)
                        ? mt_rand(-1000, 1000) / pi()
                        : abs(mt_rand(-1000, 1000))) / pi();

                yield floatval(mt_rand(0, 1)
                        ? mt_rand(-100, 100) / pi()
                        : abs(mt_rand(-100, 100))) / pi();

                yield floatval(number_format(mt_rand(0, 1)
                    ? mt_rand(-10, 10) / pi()
                    : abs(mt_rand(-10, 10)) / pi(), mt_rand(5, 8)));

                yield floatval(number_format(mt_rand(0, 1)
                    ? mt_rand(0, 1000) / pi()
                    : abs(mt_rand(0, 1000)) / pi(), mt_rand(3, 5)));

                yield floatval(number_format(mt_rand(0, 1)
                    ? mt_rand(-100, 0) / pi()
                    : abs(mt_rand(-100, 0)) / pi(), 2));

                yield floatval(number_format(mt_rand(0, 1)
                    ? mt_rand(-1000, 0) / pi()
                    : abs(mt_rand(-1000, 0)) / pi(), 1));
            }
        }

        /**
         * @return \Generator
         */
        static function _string()
        {
            $chars = 'asdASDęóąśłżźćńĘÓĄŚŁŻŹĆŃ<>,.?/:;{}[]+_-=!@#$%^&*() 0987654321~`';
            $chars = str_split($chars);

            $chars[] = "\x00";
            $chars[] = "\x04";
            $chars[] = ''; //empty

            $_min = 0;
            $_max = sizeof($chars) - 1;

            $char = function () use ($chars, $_min, $_max) {
                return $chars[mt_rand($_min, $_max)];
            };

            yield 'xyz';
            yield 'XYZ';

            for ($i = 0; $i <= self::$max; ++$i) {
                yield strval($char() . $char() . $char() . $char() . $char());
            }
        }

        /**
         * @return \Generator
         */
        static function _array()
        {
            $key = function () {
                switch (mt_rand(1, 3)) {
                    case 1:
                        return intval(mt_rand(0, 1)
                            ? mt_rand(-PHP_INT_MAX, mt_getrandmax()) / pi()
                            : abs(mt_rand(-PHP_INT_MAX, mt_getrandmax())) / pi());

                    case 2:
                        return floatval(mt_rand(0, 1)
                            ? mt_rand(-PHP_INT_MAX, mt_getrandmax()) / pi()
                            : abs(mt_rand(-PHP_INT_MAX, mt_getrandmax())) / pi());

                    case 3:
                        return substr(md5(mt_rand()), mt_rand(0, 30));
                }
            };

            $value = function () {
                switch (mt_rand(1, 7)) {
                    case 1:
                        return intval(mt_rand(0, 1)
                            ? mt_rand(-PHP_INT_MAX, mt_getrandmax()) / pi()
                            : abs(mt_rand(-PHP_INT_MAX, mt_getrandmax())) / pi());

                    case 2:
                        return floatval(mt_rand(0, 1)
                            ? mt_rand(-PHP_INT_MAX, mt_getrandmax()) / pi()
                            : abs(mt_rand(-PHP_INT_MAX, mt_getrandmax())) / pi());

                    case 3:
                        return substr(md5(mt_rand()), mt_rand(0, 30));

                    case 4:
                        return [mt_rand()];

                    case 5:
                        return new \StdClass;

                    case 6:
                        return tmpfile();

                    case 7:
                        return null;
                }
            };

            $randomArray = function ($max = null, &$tmp = []) use (&$randomArray, $key, $value) {
                if (null === $max) $randomArray(mt_rand(1, 2), $tmp);
                else if ($max) $randomArray(--$max, $tmp);
                return $tmp = array_merge($tmp, [($key()) => $value()]);
            };

            yield [123];
            yield ["123"];
            yield [];

            for ($i = 0; $i <= self::$max; ++$i) yield $randomArray();
        }

        /**
         * @return \Generator
         */
        static function _object()
        {
            yield (object)1;
            yield (object)2;

            for ($i = 0; $i <= self::$max; ++$i) {
                yield (object)(mt_rand(0, 1)
                    ? mt_rand(-PHP_INT_MAX, mt_getrandmax()) / pi()
                    : abs(mt_rand(-PHP_INT_MAX, mt_getrandmax())) / pi());
            }
        }

        /**
         * @return \Generator
         */
        static function _resource()
        {
            $res = tmpfile();

            yield $res;
            yield $res;

            for ($i = 0; $i <= self::$max; ++$i) yield $res;
        }

        /**
         * @return \Generator
         */
        static function _null()
        {
            yield null;
            yield null;

            for ($i = 0; $i <= self::$max; ++$i) yield null;
        }

        /**
         * @param integer $exclude
         * @return \Generator
         */
        static function _all($exclude = 0)
        {
            if (!($exclude & self::_ARRAY)) foreach (self::_array() as $data) yield $data;
            if (!($exclude & self::_BOOLEAN)) foreach (self::_boolean() as $data) yield $data;
            if (!($exclude & self::_FLOAT)) foreach (self::_float() as $data) yield $data;
            if (!($exclude & self::_INTEGER)) foreach (self::_integer() as $data) yield $data;
            if (!($exclude & self::_NULL)) foreach (self::_null() as $data) yield $data;
            if (!($exclude & self::_OBJECT)) foreach (self::_object() as $data) yield $data;
            if (!($exclude & self::_RESOURCE)) foreach (self::_resource() as $data) yield $data;
            if (!($exclude & self::_STRING)) foreach (self::_string() as $data) yield $data;
        }
    }
}