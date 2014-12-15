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
     * Class RandomData
     * @package PowerEcommerce\System
     */
    class RandomData
    {
        function _boolean()
        {
            $tmp = [true, false];
            for ($i = 0; $i <= 10009; ++$i) {
                $tmp[] = mt_rand(0, 1) ? true : false;
            }
            return $tmp;
        }

        function _integer()
        {
            $tmp = [-PHP_INT_MAX, PHP_INT_MAX];
            for ($i = 0; $i <= 1000; ++$i) {
                $tmp[] = intval(mt_rand(0, 1) ? mt_rand(-PHP_INT_MAX, mt_getrandmax()) : abs(mt_rand(-PHP_INT_MAX, mt_getrandmax())));
                $tmp[] = intval(mt_rand(0, 1) ? mt_rand(-PHP_INT_MAX / mt_rand(1000, 10000), mt_getrandmax()) : abs(mt_rand(-PHP_INT_MAX / mt_rand(1000, 10000), mt_getrandmax())));
                $tmp[] = intval(mt_rand(0, 1) ? mt_rand(-PHP_INT_MAX / mt_rand(10000, 100000), mt_getrandmax()) : abs(mt_rand(-PHP_INT_MAX / mt_rand(10000, 100000), mt_getrandmax())));
                $tmp[] = intval(mt_rand(0, 1) ? mt_rand(-PHP_INT_MAX / mt_rand(100000000, 1000000000), mt_getrandmax()) : abs(mt_rand(-PHP_INT_MAX / mt_rand(100000000, 1000000000), mt_getrandmax())));
                $tmp[] = intval(mt_rand(0, 1) ? mt_rand(-1000, 1000) : abs(mt_rand(-1000, 1000)));
                $tmp[] = intval(mt_rand(0, 1) ? mt_rand(-100, 100) : abs(mt_rand(-100, 100)));
                $tmp[] = intval(mt_rand(0, 1) ? mt_rand(-10, 10) : abs(mt_rand(-10, 10)));
                $tmp[] = intval(mt_rand(0, 1) ? mt_rand(0, 1000) : abs(mt_rand(0, 1000)));
                $tmp[] = intval(mt_rand(0, 1) ? mt_rand(-100, 0) : abs(mt_rand(-100, 0)));
                $tmp[] = intval(mt_rand(0, 1) ? mt_rand(-1000, 0) : abs(mt_rand(-1000, 0)));
            }
            return $tmp;
        }

        function _float()
        {
            $tmp = [floatval(-PHP_INT_MAX), floatval(PHP_INT_MAX)];
            for ($i = 0; $i <= 1000; ++$i) {
                $tmp[] = floatval(mt_rand(0, 1) ? mt_rand(-PHP_INT_MAX, mt_getrandmax()) : abs(mt_rand(-PHP_INT_MAX, mt_getrandmax())));
                $tmp[] = floatval(mt_rand(0, 1) ? mt_rand(-PHP_INT_MAX / mt_rand(1000, 10000), mt_getrandmax()) : abs(mt_rand(-PHP_INT_MAX / mt_rand(1000, 10000), mt_getrandmax())));
                $tmp[] = floatval(mt_rand(0, 1) ? mt_rand(-PHP_INT_MAX / mt_rand(10000, 100000), mt_getrandmax()) : abs(mt_rand(-PHP_INT_MAX / mt_rand(10000, 100000), mt_getrandmax())));
                $tmp[] = floatval(mt_rand(0, 1) ? mt_rand(-PHP_INT_MAX / mt_rand(100000000, 1000000000), mt_getrandmax()) : abs(mt_rand(-PHP_INT_MAX / mt_rand(100000000, 1000000000), mt_getrandmax())));
                $tmp[] = floatval(mt_rand(0, 1) ? mt_rand(-1000, 1000) / pi() : abs(mt_rand(-1000, 1000))) / pi();
                $tmp[] = floatval(mt_rand(0, 1) ? mt_rand(-100, 100) / pi() : abs(mt_rand(-100, 100))) / pi();
                $tmp[] = floatval(number_format(mt_rand(0, 1) ? mt_rand(-10, 10) / pi() : abs(mt_rand(-10, 10)) / pi(), mt_rand(5, 8)));
                $tmp[] = floatval(number_format(mt_rand(0, 1) ? mt_rand(0, 1000) / pi() : abs(mt_rand(0, 1000)) / pi(), mt_rand(3, 5)));
                $tmp[] = floatval(number_format(mt_rand(0, 1) ? mt_rand(-100, 0) / pi() : abs(mt_rand(-100, 0)) / pi(), 2));
                $tmp[] = floatval(number_format(mt_rand(0, 1) ? mt_rand(-1000, 0) / pi() : abs(mt_rand(-1000, 0)) / pi(), 1));
            }
            return $tmp;
        }

        function _string()
        {
            $chars = 'asdASDęóąśłżźćńĘÓĄŚŁŻŹĆŃ<>,.?/:;{}[]+_-=!@#$%^&*() 0987654321~`';
            $chars = str_split($chars);
            $chars[] = "\x00";
            $chars[] = "\x04";
            $chars[] = ''; //empty
            $min = 0;
            $max = sizeof($chars) - 1;
            $char = function () use ($chars, $min, $max) {
                return $chars[mt_rand($min, $max)];
            };
            $tmp = ['xyz', 'XYZ'];
            for ($i = 0; $i <= 10009; ++$i) {
                $tmp[] = strval($char() . $char() . $char() . $char() . $char());
            }
            return $tmp;
        }

        function _array()
        {
            $value = function () {
                switch (mt_rand(1, 7)) {
                    case 1:
                        return intval(mt_rand(0, 1) ? mt_rand(-PHP_INT_MAX, mt_getrandmax()) / pi() : abs(mt_rand(-PHP_INT_MAX, mt_getrandmax())) / pi());

                    case 2:
                        return floatval(mt_rand(0, 1) ? mt_rand(-PHP_INT_MAX, mt_getrandmax()) / pi() : abs(mt_rand(-PHP_INT_MAX, mt_getrandmax())) / pi());

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
            $randomArray = function ($max = null, &$tmp = []) use (&$randomArray, $value) {
                if (null === $max) $tmp = $randomArray(mt_rand(1, 2));
                else if ($max) $tmp = $randomArray(--$max, $tmp);
                return array_merge($tmp, [$value()]);
            };
            $tmp = [[123], ["123"]];
            for ($i = 0; $i <= 10009; ++$i) {
                $tmp[] = $randomArray();
            }
            return $tmp;
        }

        function _object()
        {
            $tmp = [(object)1, (object)2];
            for ($i = 0; $i <= 10009; ++$i) {
                $tmp[] = (object)(mt_rand(0, 1) ? mt_rand(-PHP_INT_MAX, mt_getrandmax()) / pi() : abs(mt_rand(-PHP_INT_MAX, mt_getrandmax())) / pi());
            }
            return $tmp;
        }

        function _resource()
        {
            $res = tmpfile();
            $tmp = [$res, $res];
            for ($i = 0; $i <= 10009; ++$i) $tmp[] = $res;
            return $tmp;
        }

        function _null()
        {
            $tmp = [null, null];
            for ($i = 0; $i <= 10009; ++$i) $tmp[] = null;
            return $tmp;
        }
    }
}
