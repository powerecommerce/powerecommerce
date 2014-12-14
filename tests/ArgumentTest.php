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
     * Class ArgumentTest
     * @package PowerEcommerce\System
     */
    class ArgumentTest extends \PHPUnit_Framework_TestCase
    {
        function testIsArray()
        {
            $this->assertTrue((new Argument(['ok']))->isArray());
            $this->assertFalse((new Argument('no'))->isArray());
        }

        function testIsBool()
        {
            $this->assertTrue((new Argument(true))->isBool());
            $this->assertFalse((new Argument(1))->isBool());
        }

        function testIsCallable()
        {
            $this->assertTrue((new Argument(function () {
            }))->isCallable());
            $this->assertTrue((new Argument([$this, 'testIsCallable']))->isCallable());
            $this->assertTrue((new Argument('\PowerEcommerce\System\ArgumentTest::testIsCallable'))->isCallable());
            $this->assertFalse((new Argument(1))->isCallable());
        }

        function testIsDouble()
        {
            $this->assertTrue((new Argument(1.0))->isDouble());
            $this->assertFalse((new Argument(1))->isDouble());
        }

        function testIsFloat()
        {
            $this->assertTrue((new Argument(1.0))->isFloat());
            $this->assertFalse((new Argument(1))->isFloat());
        }

        function testIsInt()
        {
            $this->assertTrue((new Argument(1))->isInt());
            $this->assertFalse((new Argument(1.0))->isInt());
        }

        function testIsInteger()
        {
            $this->assertTrue((new Argument(1))->isInteger());
            $this->assertFalse((new Argument(1.0))->isInteger());
        }

        function testIsLong()
        {
            $this->assertTrue((new Argument(1))->isInteger());
            $this->assertFalse((new Argument(1.0))->isInteger());
        }

        function testIsNull()
        {
            $this->assertTrue((new Argument(null))->isNull());
            $this->assertFalse((new Argument(0))->isNull());
        }

        function testIsNumeric()
        {
            $this->assertTrue((new Argument('123.56'))->isNumeric());
            $this->assertTrue((new Argument(123.56))->isNumeric());
            $this->assertTrue((new Argument(123))->isNumeric());
            $this->assertFalse((new Argument('123,12'))->isNumeric());
        }

        function testIsNumber()
        {
            $this->assertTrue((new Argument('123.56'))->isNumber());
            $this->assertTrue((new Argument(123.56))->isNumber());
            $this->assertTrue((new Argument(123))->isNumber());
            $this->assertFalse((new Argument('123,12'))->isNumber());
        }

        function testIsObject()
        {
            $this->assertTrue((new Argument(new \StdClass()))->isObject());
            $this->assertFalse((new Argument(null))->isObject());
        }

        function testIsReal()
        {
            $this->assertTrue((new Argument(1.2))->isReal());
            $this->assertFalse((new Argument(1))->isReal());
        }

        function testIsResource()
        {
            $this->assertTrue((new Argument(tmpfile()))->isResource());
            $this->assertFalse((new Argument(null))->isResource());
        }

        function testIsScalar()
        {
            $this->assertTrue((new Argument(1))->isScalar());
            $this->assertTrue((new Argument(1.2))->isScalar());
            $this->assertTrue((new Argument('1.2'))->isScalar());
            $this->assertTrue((new Argument(true))->isScalar());

            $this->assertFalse((new Argument(null))->isScalar());
            $this->assertFalse((new Argument([]))->isScalar());
            $this->assertFalse((new Argument(new \StdClass()))->isScalar());
            $this->assertFalse((new Argument(tmpfile()))->isScalar());
        }

        function testIsString()
        {
            $this->assertTrue((new Argument('1.2'))->isString());

            $this->assertFalse((new Argument(null))->isString());
            $this->assertFalse((new Argument([]))->isString());
            $this->assertFalse((new Argument(new \StdClass()))->isString());
            $this->assertFalse((new Argument(tmpfile()))->isString());
            $this->assertFalse((new Argument(1))->isString());
            $this->assertFalse((new Argument(1.2))->isString());
        }

        function testIs()
        {
            $this->assertTrue((new Argument(['ok']))->is(TypeCode::PHP_ARRAY));
            $this->assertTrue((new Argument('no'))->is(TypeCode::PHP_ARRAY | TypeCode::STRING | TypeCode::PHP_STRING));
            $this->assertTrue((new Argument('no'))->is(TypeCode::PHP_ARRAY | TypeCode::STRING | ~TypeCode::PHP_STRING));
            $this->assertFalse((new Argument('no'))->is(TypeCode::PHP_ARRAY | TypeCode::STRING));
            $this->assertFalse((new Argument('no'))->is(TypeCode::PHP_ARRAY | TypeCode::STRING & ~TypeCode::PHP_STRING));
            $this->assertTrue((new Argument(true))->is(TypeCode::PHP_BOOL));
            $this->assertFalse((new Argument(1))->is(TypeCode::PHP_BOOL));
            $this->assertTrue((new Argument(function () {
            }))->is(TypeCode::PHP_CALLABLE));
            $this->assertTrue((new Argument([$this, 'testIsCallable']))->is(TypeCode::PHP_CALLABLE));
            $this->assertTrue((new Argument('\PowerEcommerce\System\ArgumentTest::testIsCallable'))->is(TypeCode::STRING | TypeCode::PHP_CALLABLE));
            $this->assertFalse((new Argument(1))->is(TypeCode::PHP_CALLABLE));
            $this->assertTrue((new Argument(1.0))->is(TypeCode::PHP_DOUBLE));
            $this->assertFalse((new Argument(1))->is(TypeCode::PHP_DOUBLE));
            $this->assertTrue((new Argument(1.0))->is(TypeCode::PHP_FLOAT));
            $this->assertFalse((new Argument(1))->is(TypeCode::PHP_FLOAT));
            $this->assertTrue((new Argument(1))->is(TypeCode::PHP_INT));
            $this->assertFalse((new Argument(1.0))->is(TypeCode::PHP_INT));
            $this->assertTrue((new Argument(1))->is(TypeCode::PHP_INTEGER));
            $this->assertFalse((new Argument(1.0))->is(TypeCode::PHP_INTEGER));
            $this->assertTrue((new Argument(1))->is(TypeCode::PHP_INTEGER));
            $this->assertFalse((new Argument(1.0))->is(TypeCode::PHP_INTEGER));
            $this->assertTrue((new Argument(null))->is(TypeCode::PHP_NULL));
            $this->assertFalse((new Argument(0))->is(TypeCode::PHP_NULL));
            $this->assertTrue((new Argument('123.56'))->is(TypeCode::PHP_NUMERIC));
            $this->assertTrue((new Argument(123.56))->is(TypeCode::PHP_NUMERIC));
            $this->assertTrue((new Argument(123))->is(TypeCode::PHP_NUMERIC));
            $this->assertFalse((new Argument('123,12'))->is(TypeCode::PHP_NUMERIC));
            $this->assertTrue((new Argument(new \StdClass()))->is(TypeCode::PHP_OBJECT));
            $this->assertFalse((new Argument(null))->is(TypeCode::PHP_OBJECT));
            $this->assertTrue((new Argument(1.2))->is(TypeCode::PHP_REAL));
            $this->assertFalse((new Argument(1))->is(TypeCode::PHP_REAL));
            $this->assertTrue((new Argument(tmpfile()))->is(TypeCode::PHP_RESOURCE));
            $this->assertFalse((new Argument(null))->is(TypeCode::PHP_RESOURCE));
            $this->assertTrue((new Argument(1))->is(TypeCode::PHP_SCALAR));
            $this->assertTrue((new Argument(1.2))->is(TypeCode::PHP_SCALAR));
            $this->assertTrue((new Argument('1.2'))->is(TypeCode::PHP_SCALAR));
            $this->assertTrue((new Argument(true))->is(TypeCode::PHP_SCALAR));
            $this->assertFalse((new Argument(null))->is(TypeCode::PHP_SCALAR));
            $this->assertFalse((new Argument([]))->is(TypeCode::PHP_SCALAR));
            $this->assertFalse((new Argument(new \StdClass()))->is(TypeCode::PHP_SCALAR));
            $this->assertFalse((new Argument(tmpfile()))->is(TypeCode::PHP_SCALAR));
            $this->assertTrue((new Argument('1.2'))->is(TypeCode::PHP_STRING));
            $this->assertFalse((new Argument(null))->is(TypeCode::PHP_STRING));
            $this->assertFalse((new Argument([]))->is(TypeCode::PHP_STRING));
            $this->assertFalse((new Argument(new \StdClass()))->is(TypeCode::PHP_STRING));
            $this->assertFalse((new Argument(tmpfile()))->is(TypeCode::PHP_STRING));
            $this->assertFalse((new Argument(1))->is(TypeCode::PHP_STRING));
            $this->assertFalse((new Argument(1.2))->is(TypeCode::PHP_STRING));
        }

        function testOfBlank()
        {
            $this->assertTrue((new Argument(new Blank()))->ofBlank());
            $this->assertFalse((new Argument(null))->ofBlank());
        }

        function testOfCollection()
        {
            $this->assertTrue((new Argument(new Collection()))->ofCollection());
            $this->assertFalse((new Argument(null))->ofCollection());
        }

        function testOfContainer()
        {
            $this->assertTrue((new Argument(new Container()))->ofContainer());
            $this->assertFalse((new Argument(null))->ofContainer());
        }

        function testOfDateTime()
        {
            $this->assertTrue((new Argument(new DateTime()))->ofDateTime());
            $this->assertFalse((new Argument(null))->ofDateTime());
        }

        function testOfNumber()
        {
            $this->assertTrue((new Argument(new Number()))->ofNumber());
            $this->assertFalse((new Argument(null))->ofNumber());
        }

        function testOfObject()
        {
            $this->assertTrue((new Argument(new Number()))->ofObject());
            $this->assertFalse((new Argument(null))->ofObject());
        }

        function testOfString()
        {
            $this->assertTrue((new Argument(new String()))->ofString());
            $this->assertFalse((new Argument(null))->ofString());
        }

        function testOfTimeZone()
        {
            $this->assertTrue((new Argument(new TimeZone()))->ofTimeZone());
            $this->assertFalse((new Argument(null))->ofTimeZone());
        }

        function testOf()
        {
            $this->assertTrue((new Argument(new Blank()))->of(TypeCode::BLANK));
            $this->assertFalse((new Argument(null))->of(TypeCode::BLANK));
            $this->assertTrue((new Argument(new Container()))->of(TypeCode::BLANK | TypeCode::CONTAINER));
            $this->assertFalse((new Argument(null))->of(TypeCode::CONTAINER));
            $this->assertTrue((new Argument(new DateTime()))->of(TypeCode::DATETIME));
            $this->assertFalse((new Argument(null))->of(TypeCode::DATETIME));
            $this->assertTrue((new Argument(new Number()))->of(TypeCode::NUMBER));
            $this->assertFalse((new Argument(null))->of(TypeCode::NUMBER));
            $this->assertTrue((new Argument(new String()))->of(TypeCode::STRING));
            $this->assertFalse((new Argument(null))->of(TypeCode::STRING));
            $this->assertTrue((new Argument(new TimeZone()))->of(TypeCode::TIMEZONE));
            $this->assertFalse((new Argument(null))->of(TypeCode::TIMEZONE));
        }

        function testStrict()
        {
            $this->assertTrue((new Argument(new TimeZone()))->strict(TypeCode::PHP_NULL | TypeCode::PHP_ARRAY | TypeCode::TIMEZONE | TypeCode::BLANK));
            $this->assertTrue((new Argument([]))->strict(TypeCode::PHP_NULL | TypeCode::PHP_ARRAY | TypeCode::TIMEZONE | TypeCode::BLANK));
        }

        /**
         * @expectedException \InvalidArgumentException
         */
        function testStrictInvalidArgumentException()
        {
            $this->assertTrue((new Argument(''))->strict(TypeCode::PHP_NULL | TypeCode::PHP_ARRAY | TypeCode::TIMEZONE | TypeCode::BLANK));
        }

        /**
         * @expectedException \InvalidArgumentException
         */
        function testInvalid()
        {
            (new Argument('Test'))->invalid();
        }

        function testAssertEquals()
        {
            $this->assertTrue((new Argument('1'))->assertEquals(1));
            $this->assertTrue((new Argument('1'))->assertEquals('1'));
            $this->assertFalse((new Argument('1'))->assertEquals(2));
        }

        function testGreaterThan()
        {
            $this->assertTrue((new Argument('1'))->assertGreaterThan(0));
            $this->assertTrue((new Argument('1'))->assertGreaterThan('0.5'));
            $this->assertFalse((new Argument('1'))->assertGreaterThan(2));
        }

        function testGreaterThanOrEqual()
        {
            $this->assertTrue((new Argument('1'))->assertGreaterThanOrEqual(0));
            $this->assertTrue((new Argument('1'))->assertGreaterThanOrEqual('1'));
            $this->assertFalse((new Argument('1'))->assertGreaterThanOrEqual(2));
        }

        function testInstanceOf()
        {
            $this->assertTrue((new Argument(new Blank()))->assertInstanceOf(new Blank()));
            $this->assertFalse((new Argument(new Blank()))->assertInstanceOf(new Collection()));
        }

        function testLessThan()
        {
            $this->assertTrue((new Argument('1'))->assertLessThan(2));
            $this->assertTrue((new Argument('1'))->assertLessThan('1.001'));
            $this->assertFalse((new Argument('1'))->assertLessThan(0.7));
        }

        function testLessThanOrEqual()
        {
            $this->assertTrue((new Argument('1'))->assertLessThanOrEqual(2));
            $this->assertTrue((new Argument('1'))->assertLessThanOrEqual('1.000'));
            $this->assertFalse((new Argument('1'))->assertLessThanOrEqual(0.7));
        }

        function testSame()
        {
            $this->assertTrue((new Argument('1'))->assertSame('1'));
            $this->assertTrue((new Argument(null))->assertSame(null));
            $this->assertFalse((new Argument('1'))->assertSame(1));
        }
    }
}
