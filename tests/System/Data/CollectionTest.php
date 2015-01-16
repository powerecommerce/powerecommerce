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

namespace PowerEcommerce\System\Data;

use PowerEcommerce\System\Object;
use PowerEcommerce\System\Util\BaseUnit;
use PowerEcommerce\System\Util\DataGenerator;

/**
 * @group System
 * @group Object
 * @group Data
 * @group Collection
 */
class CollectionTest extends BaseUnit
{
    /**
     * @var Collection
     */
    protected $data;

    function testMain()
    {
        $value = [7 => new Object('Test')];
        $data = new Collection($value);

        $this->assertSame(spl_object_hash($data), $data->getHashCode());

        $this->assertNotSame([], $data->getValue());
        $this->assertSame($value, $data->getValue());

        $this->assertSame($value, $data->setValue($value)->getValue());
        $this->assertSame($value, $data->setValue(new Object($value))->getValue());
        $this->assertSame('', (string)$data);

        $this->assertNotSame(true, $data->setValue($value)->getValue());
        $this->assertNotSame('1', (string)$data);
    }

    function testConstructorInvalidArgumentException()
    {
        $i = $j = 0;

        $test = function ($data) use (&$i) {
            try {
                new Collection($data);
            } catch (\InvalidArgumentException $e) {
                ++$i;
            }
            return 1;
        };

        foreach (DataGenerator::_all(DataGenerator::_ARRAY) as $data) {
            $j += $test($data);
            $this->assertEquals($j, $i);
        }
    }

    function testSetValue()
    {
        foreach (DataGenerator::_array() as $data) {
            $dataTest = [];

            foreach ($data as $key => $value) {
                is_string($key) && $dataTest[$key] = new Object($value);
            }

            $this->assertSame($dataTest, $this->data->setValue($dataTest)->getValue());
        }
    }

    function testAdd()
    {
        $value = new Object();

        $this->assertSame(
            ['Test 1' => $value],
            $this->data->add(new String('Test 1'), $value)->getValue()
        );

        $this->assertSame(
            ['Test 1' => $value, 'Test 2' => $value],
            $this->data->add(new String('Test 2'), $value)->getValue()
        );
    }

    function testAddValue()
    {
        $value = new Object();

        $this->assertSame(
            ['Test 1' => $value],
            $this->data->addValue(['Test 1' => $value])->getValue()
        );

        $this->assertSame(
            ['Test 1' => $value, 'Test 2' => $value],
            $this->data->addValue(['Test 2' => $value])->getValue()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testAddException()
    {
        $this->testAdd();
        $this->data->add(new String('Test 1'), new Object());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testAddValueException()
    {
        $this->testAddValue();
        $this->data->addValue(['Test 1' => new Object()]);
    }

    function testClear()
    {
        $this->testAdd();

        $this->assertSame(2, sizeof($this->data->getValue()));
        $this->data->clear();
        $this->assertSame(0, sizeof($this->data->getValue()));
    }

    function testDel()
    {
        $this->testAdd();

        $this->assertSame(2, sizeof($this->data->getValue()));

        $this->data->del(new String('Test 1'));
        $this->assertSame(1, sizeof($this->data->getValue()));

        $this->data->del(new String('Test 2'));
        $this->assertSame(0, sizeof($this->data->getValue()));
    }

    function testSetValueInvalidArgumentException()
    {
        $i = $j = 0;

        $test = function ($data) use (&$i) {
            try {
                $this->data->setValue($data);
            } catch (\InvalidArgumentException $e) {
                ++$i;
            }
            return 1;
        };

        foreach (DataGenerator::_all(DataGenerator::_ARRAY) as $data) {
            $j += $test($data);
            $this->assertEquals($j, $i);
        }
    }

    function testIterator()
    {
        $assert = function ($data) {
            $this->data->setValue($data);

            foreach ($this->data as $key => $value) {
                $this->assertTrue($key === key($data));
                $this->assertTrue($value === current($data));

                next($data);
            }
        };

        foreach (DataGenerator::_array() as $data) {
            $dataTest = [];

            foreach ($data as $key => $value) {
                is_string($key) && $dataTest[$key] = new Object($value);
            }

            $assert($dataTest);
        }
    }

    function testCast()
    {
        $obj = new String();
        $this->assertSame($this->data->setValue([new Object('Test')])->cast($obj), $obj);
        $this->assertSame($this->data->setValue(['Test' => new String('Test')])->cast($obj), $obj);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testCastException()
    {
        $obj = new Integer();
        $this->data->cast($obj);
    }

    function testLength()
    {
        $obj = new Object();
        $this->assertEquals(3, $this->data->setValue([$obj, $obj, $obj])->length());
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->data = new Collection;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}