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

namespace PowerEcommerce\System\Util {
    use PowerEcommerce\System\Data\Blank;
    use PowerEcommerce\System\Data\Boolean;
    use PowerEcommerce\System\Data\Collection;
    use PowerEcommerce\System\Data\Float;
    use PowerEcommerce\System\Data\Integer;
    use PowerEcommerce\System\Data\String;
    use PowerEcommerce\System\Object;

    /**
     * Class BaseUnit
     * @package PowerEcommerce\System\Util
     */
    class BaseUnit extends \PHPUnit_Framework_TestCase
    {
        /**
         * @return \Generator
         */
        static function _object()
        {
            yield new Object();
            yield new Blank();
            yield new Boolean(true);
            yield new Boolean(false);
            yield new Collection();
            yield new Float();
            yield new Integer();
            yield new String();
        }

        /**
         * @return \Generator
         */
        static function _strict()
        {
            yield [true, 1];
            yield [true, -1];
            yield [true, "1"];
            yield [true, "-1"];
            yield [true, "php"];

            yield [false, 0];
            yield [false, "0"];
            yield [false, null];
            yield [false, []];
            yield [false, ""];

            yield [1, true];
            yield [1, "1"];

            yield [0, false];
            yield [0, "0"];
            yield [0, null];
            yield [0, "php"];
            yield [0, ""];

            yield [-1, true];
            yield [-1, "-1"];

            yield [null, []];
            yield [null, ""];
        }
    }
}