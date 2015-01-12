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

use PowerEcommerce\System\Data\String\Strict;
use PowerEcommerce\System\Object;
use PowerEcommerce\System\Util\BaseUnit;
use PowerEcommerce\System\Util\DataGenerator;

/**
 * @group System
 * @group Object
 * @group Data
 * @group String
 */
class StringTest extends BaseUnit
{
    /**
     * @var \PowerEcommerce\System\Data\String
     */
    protected $data;

    function testMain()
    {
        $data = new String('Test');

        $this->assertSame(spl_object_hash($data), $data->getHashCode());

        $this->assertNotSame([], $data->getValue());
        $this->assertSame('Test', $data->getValue());

        $this->assertSame('Test 1', $data->setValue('Test 1')->getValue());
        $this->assertSame('Test 1', $data->setValue(new Object('Test 1'))->getValue());
        $this->assertSame('Test 1', (string)$data);

        $this->assertNotSame(true, $data->setValue('1')->getValue());
        $this->assertSame('1', (string)$data);
    }

    function testConstructorInvalidArgumentException()
    {
        $i = $j = 0;

        $test = function ($data) use (&$i) {
            try {
                new String($data);
            } catch (\InvalidArgumentException $e) {
                ++$i;
            }
            return 1;
        };

        foreach (DataGenerator::_all(DataGenerator::_STRING) as $data) {
            $j += $test($data);
            $this->assertEquals($j, $i);
        }
    }

    function testSetValue()
    {
        foreach (DataGenerator::_string() as $data) {
            $this->assertSame($data, $this->data->setValue($data)->getValue());
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

        foreach (DataGenerator::_all(DataGenerator::_STRING) as $data) {
            $j += $test($data);
            $this->assertEquals($j, $i);
        }
    }

    function testCompare()
    {
        $assert = function (String $data) {
            $this->assertTrue($this->data->setValue($data)->compare($data)->isTrue());
            $this->assertTrue($this->data->setValue($data)->compare($data, new Strict(false))->isTrue());
        };

        foreach (DataGenerator::_string() as $data) $assert(new String($data));
    }

    function testConcat()
    {
        $assert = function (String $data) {
            $tmp = DataGenerator::_string()->current();
            $this->assertSame($data . $tmp, $this->data->setValue($data)->concat(new String($tmp))->getValue());
        };

        foreach (DataGenerator::_string() as $data) $assert(new String($data));
    }

    function testContains()
    {
        $assert = function (String $data) {
            $this->assertTrue($this->data->setValue($data)->contains($data)->isTrue());
            $this->assertTrue($this->data->setValue($data)->contains($data, new Strict(false))->isTrue());

            $this->assertTrue($this->data->setValue($data)
                ->contains(
                    $data->substring(
                        new Integer(0),
                        new Integer((string)$data->length() > 1 ? (string)$data->length() - 1 : 1)
                    )
                )->isTrue()
            );

            $this->assertTrue($this->data->setValue($data)
                ->contains(
                    $data->substring(
                        new Integer(0),
                        new Integer((string)$data->length() > 1 ? (string)$data->length() - 1 : 1), new Strict(false)
                    )
                )->isTrue()
            );
        };

        foreach (DataGenerator::_string() as $data) $assert(new String($data));
    }

    function testSubstring()
    {
        $assert = function (String $data) {
            $max = (string)$data->length();

            if ($max) {
                $start = $max - mt_rand(0, $max - 1);
                $end = mt_rand($start, $max);
            } else {
                $start = $max;
                $end = $max;
            }

            $this->assertSame(
                (string)substr($data, $start, $end),
                $this->data->setValue($data)->substring(new Integer($start), new Integer($end))->getValue()
            );
        };

        foreach (DataGenerator::_string() as $data) $assert(new String($data));
    }

    function testTruncate()
    {
        $assert = function (String $data) {
            $max = (string)$data->length();

            if ($max) {
                $start = $max - mt_rand(0, $max - 1);
                $end = mt_rand($start, $max);
            } else {
                $start = $max;
                $end = $max;
            }

            $this->assertSame(
                (string)substr($data, $start, $end),
                $this->data->setValue($data)
                    ->truncate(new Integer($end), new Integer($start))->getValue()
            );

            $this->assertSame('', $this->data->setValue($data)->truncate()->getValue());
        };

        foreach (DataGenerator::_string() as $data) $assert(new String($data));
    }

    function testLength()
    {
        $assert = function (String $data) {
            $max = (string)$data->length();
            $this->assertEquals(strlen((string)$data), $max);
        };

        foreach (DataGenerator::_string() as $data) $assert(new String($data));
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->data = new String;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}