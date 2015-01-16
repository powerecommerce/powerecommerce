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

namespace PowerEcommerce\System;

use PowerEcommerce\System\Data\Integer;
use PowerEcommerce\System\Data\String;
use PowerEcommerce\System\Util\BaseUnit;
use PowerEcommerce\System\Util\DataGenerator;

/**
 * @group System
 * @group Object
 */
class ObjectTest extends BaseUnit
{
    /**
     * @var \PowerEcommerce\System\Object
     */
    protected $data;

    function testMain()
    {
        $data = new Object(7);

        $this->assertSame(spl_object_hash($data), $data->getHashCode());

        $this->assertSame(7, $data->getValue());
        $this->assertNotSame('7', $data->getValue());

        $this->assertSame(6, $data->setValue(6)->getValue());
        $this->assertSame(6, $data->getValue());
        $this->assertNotSame(6, $data->setValue(new Object(6))->getValue());
        $this->assertNotSame('6', $data->getValue());

        $this->assertSame('6', (string)$data);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testInvalid()
    {
        $this->data->invalid();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Right Message
     */
    function testInvalidMsg()
    {
        $this->data->invalid('Right Message');
    }

    function testDefaults()
    {
        $this->assertSame(7, $this->data->defaults(7)->getValue());
        $this->assertSame(7, $this->data->getValue());

        $this->assertNotSame('7', $this->data->getValue());
        $this->assertNotSame(8, $this->data->defaults(8)->getValue());
    }

    function testFactory()
    {
        $factory = $this->data->factory(7);
        $this->assertNotSame($factory->getHashCode(), $this->data->getHashCode());

        $this->assertSame(7, $factory->getValue());
        $this->assertNotSame('7', $factory->getValue());
        $this->assertInstanceOf('\PowerEcommerce\System\Object', $factory);

        $factory = $factory->factory(8);

        $this->assertNotSame(7, $factory->getValue());
        $this->assertSame(8, $factory->getValue());
        $this->assertInstanceOf('\PowerEcommerce\System\Object', $factory);

        $object = new Object('Factory');

        $factory1 = $object->factory($object);
        $factory2 = $factory->factory($object);

        $this->assertSame($factory1->getHashCode(), $factory2->getHashCode());
        $this->assertSame($object->getHashCode(), $factory1->getHashCode());
    }

    function testIsArray()
    {
        foreach (DataGenerator::_array() as $data) {
            $this->assertTrue($this->data->setValue($data)->isArray());
        }

        foreach (DataGenerator::_all(DataGenerator::_ARRAY) as $data) {
            $this->assertFalse($this->data->setValue($data)->isArray());
        }
    }

    function testIsBoolean()
    {
        foreach (DataGenerator::_boolean() as $data) {
            $this->assertTrue($this->data->setValue($data)->isBool());
            $this->assertTrue($this->data->setValue($data)->isBoolean());
        }

        foreach (DataGenerator::_all(DataGenerator::_BOOLEAN) as $data) {
            $this->assertFalse($this->data->setValue($data)->isBool());
            $this->assertFalse($this->data->setValue($data)->isBoolean());
        }
    }

    function testIsCallable()
    {
        $func = function () {
        };

        $this->assertTrue($this->data->setValue([$this, 'testIsCallable'])
            ->isCallable());

        $this->assertTrue($this->data->setValue('\PowerEcommerce\System\ObjectTest::testIsCallable')
            ->isCallable());

        $this->assertTrue($this->data->setValue($func)
            ->isCallable());

        foreach (DataGenerator::_all() as $data) {
            $this->assertFalse($this->data->setValue($data)->isCallable());
        }
    }

    function testIsFloat()
    {
        foreach (DataGenerator::_float() as $data) {
            $this->assertTrue($this->data->setValue($data)->isDouble());
            $this->assertTrue($this->data->setValue($data)->isFloat());
            $this->assertTrue($this->data->setValue($data)->isReal());
        }

        foreach (DataGenerator::_all(DataGenerator::_FLOAT) as $data) {
            $this->assertFalse($this->data->setValue($data)->isDouble());
            $this->assertFalse($this->data->setValue($data)->isFloat());
            $this->assertFalse($this->data->setValue($data)->isReal());
        }
    }

    function testIsInteger()
    {
        foreach (DataGenerator::_integer() as $data) {
            $this->assertTrue($this->data->setValue($data)->isInteger());
            $this->assertTrue($this->data->setValue($data)->isInt());
            $this->assertTrue($this->data->setValue($data)->isLong());
        }

        foreach (DataGenerator::_all(DataGenerator::_INTEGER) as $data) {
            $this->assertFalse($this->data->setValue($data)->isInteger());
            $this->assertFalse($this->data->setValue($data)->isInt());
            $this->assertFalse($this->data->setValue($data)->isLong());
        }
    }

    function testIsNull()
    {
        foreach (DataGenerator::_null() as $data) {
            $this->assertTrue($this->data->setValue($data)->isNull());
        }

        foreach (DataGenerator::_all(DataGenerator::_NULL) as $data) {
            $this->assertFalse($this->data->setValue($data)->isNull());
        }
    }

    function testIsObject()
    {
        foreach (DataGenerator::_object() as $data) {
            $this->assertTrue($this->data->setValue($data)->isObject());
        }

        foreach (DataGenerator::_all(DataGenerator::_OBJECT) as $key => $data) {
            $this->assertFalse($this->data->setValue($data)->isObject());
        }
    }

    function testIsResource()
    {
        foreach (DataGenerator::_resource() as $data) {
            $this->assertTrue($this->data->setValue($data)->isResource());
        }

        foreach (DataGenerator::_all(DataGenerator::_RESOURCE) as $data) {
            $this->assertFalse($this->data->setValue($data)->isResource());
        }
    }

    function testIsString()
    {
        foreach (DataGenerator::_string() as $data) {
            $this->assertTrue($this->data->setValue($data)->isString());
        }

        foreach (DataGenerator::_all(DataGenerator::_STRING) as $data) {
            $this->assertFalse($this->data->setValue($data)->isString());
        }
    }

    function testIsScalar()
    {
        foreach (DataGenerator::_integer() as $data) {
            $this->assertTrue($this->data->setValue($data)->isScalar());
        }

        foreach (DataGenerator::_float() as $data) {
            $this->assertTrue($this->data->setValue($data)->isScalar());
        }

        foreach (DataGenerator::_string() as $data) {
            $this->assertTrue($this->data->setValue($data)->isScalar());
        }

        foreach (DataGenerator::_boolean() as $data) {
            $this->assertTrue($this->data->setValue($data)->isScalar());
        }

        foreach (DataGenerator::_all(
            DataGenerator::_INTEGER | DataGenerator::_FLOAT | DataGenerator::_STRING | DataGenerator::_BOOLEAN
        ) as $data) {
            $this->assertFalse($this->data->setValue($data)->isScalar());
        }
    }

    function testIsNumeric()
    {
        foreach (DataGenerator::_integer() as $data) {
            $this->assertTrue($this->data->setValue($data)->isNumeric());
            $this->assertTrue($this->data->setValue($data)->isNumber());
        }

        foreach (DataGenerator::_float() as $data) {
            $this->assertTrue($this->data->setValue($data)->isNumeric());
            $this->assertTrue($this->data->setValue($data)->isNumber());
        }

        foreach (DataGenerator::_all(DataGenerator::_INTEGER | DataGenerator::_FLOAT) as $data) {
            !is_numeric($data) && $this->assertFalse($this->data->setValue($data)->isNumeric());
            !is_numeric($data) && $this->assertFalse($this->data->setValue($data)->isNumber());
        }
    }

    function testClear()
    {
        $this->assertSame('Test', $this->data->setValue('Test')->getValue());
        $this->assertNotSame('Test', $this->data->setValue(new Object('Test'))->getValue());
        $this->assertSame(null, $this->data->clear()->getValue());
    }

    function testCast()
    {
        $obj = new String();
        $this->assertSame($this->data->setValue('Test')->cast($obj), $obj);
        $this->assertSame($this->data->setValue(new Object('Test'))->cast($obj), $obj);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testCastException()
    {
        $obj = new Integer();
        $this->data->setValue('Test')->cast($obj);
    }

    function testLength()
    {
        $this->assertEquals(3, $this->data->setValue('123')->length());
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->data = new Object();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}