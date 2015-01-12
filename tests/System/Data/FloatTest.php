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
 * @group Float
 */
class FloatTest extends BaseUnit
{
    /**
     * @var \PowerEcommerce\System\Data\Float
     */
    protected $data;

    /**
     * @var integer
     */
    const PRECISION = 20;

    function testMain()
    {
//        $data = new Float();
//
//        $this->assertSame(spl_object_hash($data), $data->getHashCode());
//
//        $this->assertSame('0', (string)$data->getValue());
//
//        $this->assertNotSame(7, $data->getValue());
//        $this->assertNotSame('7', $data->getValue());
//
//        $this->assertSame('7', (string)$data->setValue(7)->getValue());
//        $this->assertSame('7', (string)$data->setValue(new Object('7'))->getValue());
//        $this->assertSame('7', (string)$data);
    }

    function testConstructorInvalidArgumentException()
    {
        $i = $j = 0;

        $test = function ($data) use (&$i) {
            try {
                new Float($data);
            } catch (\InvalidArgumentException $e) {
                ++$i;
            }
            return 1;
        };

        foreach (DataGenerator::_all(DataGenerator::_STRING | DataGenerator::_FLOAT) as $data) {
            $j += $test($data);
            $this->assertEquals($j, $i);
        }
    }

    function testSetValue()
    {
        foreach (DataGenerator::_float() as $data) {
            if (false === strpos($data, '.')) continue;
            $this->assertSame((string)$data, (string)$this->data->setValue((string)$data)->getValue());
        }
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

        foreach (DataGenerator::_all(DataGenerator::_STRING | DataGenerator::_FLOAT) as $data) {
            $j += $test($data);
            $this->assertEquals($j, $i);
        }
    }

    function testAdd()
    {
        $base = $this->data->getValue();

        $assert = function (Float $data) use (&$base) {
            bcscale(self::PRECISION);
            $base = bcadd($base, $data->getValue());
            $this->assertSame((string)$base, (string)$this->data->add($data));
        };

        foreach (DataGenerator::_float() as $data) {
            if (false === strpos($data, '.')) continue;
            $assert(new Float((string)$data));
        }
    }

    function testDivide()
    {
        $base = (string)$this->data;

        $assert = function (Float $data) use (&$base) {
            if (0 == (integer)($data->getValue())) return;
            bcscale(self::PRECISION);
            $base = bcdiv((string)$base, (string)$data->getValue());
            $this->assertSame((string)$base, (string)$this->data->divide($data));
        };

        foreach (DataGenerator::_float() as $data) {
            if (false === strpos($data, '.')) continue;
            $assert(new Float((string)$data));
        }
    }

    function testModulo()
    {
        $base = (string)$this->data;

        $assert = function (Float $data) use (&$base) {
            if (0 == (integer)($data->getValue())) return;
            bcscale(self::PRECISION);
            $base = bcmod($base, $data->getValue());
            $this->assertSame((string)$base . '.', (string)$this->data->modulo($data));
        };

        foreach (DataGenerator::_float() as $data) {
            if (false === strpos($data, '.')) continue;
            $assert(new Float((string)$data));
        }
    }

    function testMultiply()
    {
        $base = (string)$this->data;

        $assert = function (Float $data) use (&$base) {
            bcscale(self::PRECISION);
            $base = bcmul($base, $data->getValue());
            $this->assertSame((string)$base, (string)$this->data->multiply($data));
        };

        foreach (DataGenerator::_float() as $data) {
            if (false === strpos($data, '.')) continue;
            $assert(new Float((string)$data));
        }
    }

    function testSubtract()
    {
        $base = (string)$this->data;

        $assert = function (Float $data) use (&$base) {
            bcscale(self::PRECISION);
            $base = bcsub($base, $data->getValue());
            $this->assertSame((string)$base, (string)$this->data->subtract($data));
        };

        foreach (DataGenerator::_float() as $data) {
            if (false === strpos($data, '.')) continue;
            $assert(new Float((string)$data));
        }
    }

    function testIncrement()
    {
        $assert = function (Float $data) {
            bcscale(self::PRECISION);
            $base = bcadd((string)$data->getValue(), 1);
            $this->assertSame((string)$base, (string)$this->data->setValue($data)->increment());
        };

        foreach (DataGenerator::_float() as $data) {
            if (false === strpos($data, '.')) continue;
            $assert(new Float((string)$data));
        }
    }

    function testDecrement()
    {
        $assert = function (Float $data) {
            bcscale(self::PRECISION);
            $base = bcsub((string)$data->getValue(), 1);
            $this->assertSame((string)$base, (string)$this->data->setValue($data)->decrement());
        };

        foreach (DataGenerator::_float() as $data) {
            if (false === strpos($data, '.')) continue;
            $assert(new Float((string)$data));
        }
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->data = new Float();
        $this->data->setPrecision(new Integer(self::PRECISION));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}