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

/**
 * @group System
 * @group Object
 * @group Data
 */
class BooleanTest extends BaseUnit
{
    /**
     * @var \PowerEcommerce\System\Data\Boolean
     */
    protected $data;

    function testMain()
    {
        $data = new Boolean(true);

        $this->assertSame(spl_object_hash($data), $data->getHashCode());

        $this->assertNotSame(7, $data->getValue());
        $this->assertNotSame('7', $data->getValue());

        $this->assertSame(false, $data->setValue(false)->getValue());
        $this->assertSame(false, $data->setValue(new Object(false))->getValue());
        $this->assertSame('', (string)$data);

        $this->assertSame(true, $data->setValue(true)->getValue());
        $this->assertSame(true, $data->setValue(new Object(true))->getValue());
        $this->assertSame('1', (string)$data);
    }

    function testIsTrue()
    {
        $this->assertTrue($this->data->isTrue());
        $this->assertFalse($this->data->isFalse());
    }

    function testIsFalse()
    {
        $this->assertTrue($this->data->setValue(false)->isFalse());
        $this->assertFalse($this->data->isTrue());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testException()
    {
        set_error_handler(function ($_, $msg) {
            $this->assertRegExp('/^.*(Missing argument 1 for PowerEcommerce)|(Undefined variable).*$/', $msg);
        });
        new Boolean();
        restore_error_handler();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testException2()
    {
        new Boolean(7);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testException3()
    {
        $this->data->setValue(7);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testClear()
    {
        $this->data->clear();
    }

    function testCast()
    {
        $obj = new String();
        $this->assertSame($this->data->cast($obj), $obj);
        $this->assertSame($this->data->setValue(new Object(true))->cast($obj), $obj);

        $obj = new Integer();
        $this->assertSame($this->data->cast($obj), $obj);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testCastException()
    {
        $obj = new Integer();
        $this->data->setValue(new Object(false))->cast($obj);
    }

    function testLength()
    {
        $this->assertEquals(1, $this->data->length()->toString());
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->data = new Boolean(true);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}