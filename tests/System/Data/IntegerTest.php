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

use PowerEcommerce\System\Data\Integer\Round\MinusInf;
use PowerEcommerce\System\Data\Integer\Round\PlusInf;
use PowerEcommerce\System\Data\Integer\Round\Zero;
use PowerEcommerce\System\Object;
use PowerEcommerce\System\Util\BaseUnit;
use PowerEcommerce\System\Util\DataGenerator;

/**
 * @group System
 * @group Object
 * @group Data
 * @group Integer
 */
class IntegerTest extends BaseUnit
{
    /**
     * @var \PowerEcommerce\System\Data\Integer
     */
    protected $data;

    function testMain()
    {
        $data = new Integer();

        $this->assertSame(spl_object_hash($data), $data->getHashCode());

        $this->assertSame('0', (string)$data->getValue());

        $this->assertNotSame(7, $data->getValue());
        $this->assertNotSame('7', $data->getValue());

        $this->assertSame('7', (string)$data->setValue(7)->getValue());
        $this->assertSame('7', (string)$data->setValue(new Object('7'))->getValue());
        $this->assertSame('7', (string)$data);
    }

    function testConstructorInvalidArgumentException()
    {
        $i = $j = 0;

        $test = function ($data) use (&$i) {
            try {
                new Integer($data);
            } catch (\InvalidArgumentException $e) {
                ++$i;
            }
            return 1;
        };

        foreach (DataGenerator::_all(DataGenerator::_STRING | DataGenerator::_INTEGER) as $data) {
            if (null === $data) continue;
            $j += $test($data);
            $this->assertEquals($j, $i);
        }
    }

    function testSetValue()
    {
        foreach (DataGenerator::_integer() as $data) {
            $this->assertSame((string)$data, (string)$this->data->setValue($data)->getValue());
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

        foreach (DataGenerator::_all(DataGenerator::_STRING | DataGenerator::_INTEGER) as $data) {
            $j += $test($data);
            $this->assertEquals($j, $i);
        }
    }

    function testAdd()
    {
        $base = gmp_init((string)$this->data);

        $assert = function (Integer $data) use (&$base) {
            $base += $data->getValue();
            $this->assertSame((string)$base, (string)$this->data->add($data));
        };

        foreach (DataGenerator::_integer() as $data) $assert(new Integer($data));
    }

    function testDivide()
    {
        $base = gmp_init((string)$this->data);

        $assert = function (Integer $data) use (&$base) {
            if (($data->getValue() == 0)) return;
            $base /= $data->getValue();
            $this->assertSame((string)$base, (string)$this->data->divide($data));
        };

        foreach (DataGenerator::_integer() as $data) $assert(new Integer($data));
    }

    function testModulo()
    {
        $base = gmp_init((string)$this->data);

        $assert = function (Integer $data) use (&$base) {
            if (($data->getValue() == 0)) return;
            $base %= $data->getValue();
            $this->assertSame((string)$base, (string)$this->data->modulo($data));
        };

        foreach (DataGenerator::_integer() as $data) $assert(new Integer($data));
    }

    function testMultiply()
    {
        $base = gmp_init((string)$this->data);

        $assert = function (Integer $data) use (&$base) {
            $base *= $data->getValue();
            $this->assertSame((string)$base, (string)$this->data->multiply($data));
        };

        foreach (DataGenerator::_integer() as $data) $assert(new Integer($data));
    }

    function testSubtract()
    {
        $base = gmp_init((string)$this->data);

        $assert = function (Integer $data) use (&$base) {
            $base -= $data->getValue();
            $this->assertSame((string)$base, (string)$this->data->subtract($data));
        };

        foreach (DataGenerator::_integer() as $data) $assert(new Integer($data));
    }

    function testIncrement()
    {
        $assert = function (Integer $data) {
            $base = gmp_add((string)$data->getValue(), 1);
            $this->assertSame((string)$base, (string)$this->data->setValue($data)->increment());
        };

        foreach (DataGenerator::_integer() as $data) $assert(new Integer($data));
    }

    function testDecrement()
    {
        $assert = function (Integer $data) {
            $base = gmp_sub((string)$data->getValue(), 1);
            $this->assertSame((string)$base, (string)$this->data->setValue($data)->decrement());
        };

        foreach (DataGenerator::_integer() as $data) $assert(new Integer($data));
    }

    function testDefaults()
    {
        $this->assertSame('1', $this->data->defaults(1)->toString());
    }

    function testDivideRound()
    {
        $this->data->setValue(1);
        $this->assertSame('1', $this->data->divide(new Integer(3), new PlusInf())->toString());

        $this->data->setValue(-1);
        $this->assertSame('0', $this->data->divide(new Integer(4), new PlusInf())->toString());

        $this->data->setValue(-1);
        $this->assertSame('-1', $this->data->divide(new Integer(4), new MinusInf())->toString());

        $this->data->setValue(1);
        $this->assertSame('0', $this->data->divide(new Integer(2), new Zero())->toString());

        $this->data->setValue(3);
        $this->assertSame('1', $this->data->divide(new Integer(2), new Zero())->toString());
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->data = new Integer();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}