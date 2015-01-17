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

namespace PowerEcommerce\System\Security {
    use PowerEcommerce\System\Data\String;
    use PowerEcommerce\System\Object;

    /**
     * Class Component
     * @package PowerEcommerce\System\Security
     */
    abstract class Component extends Object
    {
        /**
         * @param \PowerEcommerce\System\Data\String $name
         */
        function __construct(String $name)
        {
            $this->setValue($name);
        }

        /**
         * @param \PowerEcommerce\System\Data\String $value
         * @return $this
         */
        function setValue($value)
        {
            !($value instanceof \PowerEcommerce\System\Data\String) && $this->invalid();
            return parent::setValue($value);
        }

        /**
         * @param \PowerEcommerce\System\Security\Component $component
         * @return $this
         */
        abstract function attach(Component $component);

        /**
         * @param \PowerEcommerce\System\Security\Component $component
         * @return $this
         */
        abstract function detach(Component $component);

        /**
         * @param \PowerEcommerce\System\Security\Component $component
         * @return \PowerEcommerce\System\Data\Boolean
         */
        abstract function isGranted(Component ...$component);
    }
}