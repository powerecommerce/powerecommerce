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
class BlankTest extends BaseUnit
{
    /**
     * @var \PowerEcommerce\System\Data\Blank
     */
    protected $data;

    function testMain()
    {
        $data = new Blank(null);

        $this->assertSame(spl_object_hash($data), $data->getHashCode());

        $this->assertNotSame(7, $data->getValue());
        $this->assertNotSame('7', $data->getValue());

        $this->assertSame(null, $data->setValue(null)->getValue());
        $this->assertSame(null, $data->setValue(new Object(null))->getValue());
        $this->assertSame('', (string)$data);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testException()
    {
        new Blank(7);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testException2()
    {
        $this->data->setValue(7);
    }

    function testLength()
    {
        $this->assertEquals(0, $this->data->length()->toString());
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->data = new Blank();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}