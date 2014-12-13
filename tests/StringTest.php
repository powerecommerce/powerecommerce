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
     * Class StringTest
     * @package PowerEcommerce\System
     */
    class StringTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @dataProvider dataProvider
         * @expectedException \InvalidArgumentException
         */
        function testNewInvalidArgumentException()
        {
            $args = func_get_args();
            new String((int)$args[0]);
        }

        /**
         * @dataProvider dataProvider
         * @expectedException \InvalidArgumentException
         */
        function testSetValueInvalidArgumentException()
        {
            $args = func_get_args();
            (new String())->setValue((int)$args[0]);
        }

        /**
         * @dataProvider stringProvider
         */
        function testCompare()
        {
            $data = array_slice(func_get_args(), 0, 4);
            $args = array_slice(func_get_args(), 4);

            foreach ($data as $key => $value) {
                $this->assertTrue((new String($value))->compare($args[$key], false));
                $this->assertTrue((new String($value))->compare(new String($args[$key]), false));
            }
        }

        /**
         * @dataProvider stringProvider
         */
        function testCompareStrict()
        {
            $data = array_slice(func_get_args(), 0, 4);
            $args = array_slice(func_get_args(), 4);

            $this->assertFalse((new String($data[0]))->compare(new String($args[0])));
            $this->assertTrue((new String($data[1]))->compare(new String($args[1])));
            $this->assertFalse((new String($data[2]))->compare($args[2]));
            $this->assertTrue((new String($data[3]))->compare($args[3]));
        }

        /**
         * @dataProvider stringProvider
         */
        function testConcat()
        {
            $data = array_slice(func_get_args(), 0, 4);
            $args = array_slice(func_get_args(), 4);

            foreach ($data as $key => $value) {
                $this->assertSame($data[$key] . $args[$key], (string)(new String($data[$key]))->concat($args[$key]));
                $this->assertSame($data[$key] . $args[$key], (string)(new String($data[$key]))->concat(new String($args[$key])));
            }
        }

        /**
         * @dataProvider stringProvider
         */
        function testContains()
        {
            $data = array_slice(func_get_args(), 0, 4);
            $args = array_slice(func_get_args(), 4);

            foreach ($data as $key => $value) {
                $this->assertTrue((new String($data[$key]))->contains($args[$key], false));
                $this->assertTrue((new String($data[$key]))->contains(new String($args[$key]), false));
                $this->assertFalse((new String($data[$key]))->contains('!@#'));
                $this->assertFalse((new String($data[$key]))->contains(new String('!@#')));
            }
        }

        /**
         * @dataProvider stringProvider
         */
        function testContainsStrict()
        {
            $data = array_slice(func_get_args(), 0, 4);
            $args = array_slice(func_get_args(), 4);

            $this->assertFalse((new String($data[0]))->contains(new String($args[0])));
            $this->assertTrue((new String($data[1]))->contains(new String($args[1])));
            $this->assertFalse((new String($data[2]))->contains($args[2]));
            $this->assertTrue((new String($data[3]))->contains($args[3]));
        }

        function testFormat()
        {
            $this->assertTrue((new String())->format(TypeCode::STRING) instanceof String);
        }

        function testGetTypeCode()
        {
            $this->assertSame((new String())->getTypeCode(), TypeCode::STRING);
            $this->assertNotSame((new String())->getTypeCode(), TypeCode::BLANK);
        }

        /**
         * @dataProvider stringProvider
         */
        function testJoin()
        {
            $data = func_get_args();
            $this->assertSame(implode('', $data), (string)(new String())->join($data));
        }

        function substring()
        {
            $str = new String('1234567');
            $this->assertSame($str->substring(0, 3), '123');
            $this->assertSame($str->substring(3), '4567');
        }

        function truncate()
        {
            $str = new String('1234567');
            $this->assertSame($str->truncate(0, 3)->getValue(), '123');
            $this->assertSame($str->truncate(1, 2)->getValue(), '2');
        }

        function stringProvider()
        {
            return [
                [new String('Test A'), new String('Test b'), new String("A\x00b"), new String("A\x00b"), 'Test a', 'Test b', "a\x00B", "A\x00b"]
            ];
        }

        function dataProvider()
        {
            return [
                ['Test a', 'Test b', "a\x00B", "A\x00b"]
            ];
        }
    }
}
