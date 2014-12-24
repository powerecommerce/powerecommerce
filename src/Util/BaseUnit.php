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
    use PowerEcommerce\System\Data\Argument;
    use PowerEcommerce\System\Data\Assert;
    use PowerEcommerce\System\Data\Collection;
    use PowerEcommerce\System\Data\String;
    use PowerEcommerce\System\Data\DateTime;
    use PowerEcommerce\System\Data\TimeZone;
    use PowerEcommerce\System\Data\Number;
    use PowerEcommerce\System\Data\Blank;
    use PowerEcommerce\System\Security\Component\Acl;
    use PowerEcommerce\System\Security\Component\Privilege;
    use PowerEcommerce\System\Security\Component\Resource;
    use PowerEcommerce\System\Security\Component\Role;

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
            yield new Argument();
            yield new Assert();
            yield new Blank();
            yield new Collection();
            yield new DateTime();
            yield new Number();
            yield new String();
            yield new TimeZone();

            yield new Acl('');
            yield new Privilege('');
            yield new Resource('');
            yield new Role('');
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