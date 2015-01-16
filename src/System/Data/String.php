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

namespace PowerEcommerce\System\Data {
    use PowerEcommerce\System\Data\String\Pattern;
    use PowerEcommerce\System\Data\String\Strict;
    use PowerEcommerce\System\Object;

    /**
     * Class String
     * @package PowerEcommerce\System\Data
     */
    class String extends Object
    {
        /**
         * @param string|\PowerEcommerce\System\Object $value
         */
        function __construct($value = null)
        {
            null === $value && $value = $this->_default();
            parent::__construct($value);
        }

        /**
         * @param string|\PowerEcommerce\System\Object $value String values only
         * @return $this
         */
        function setValue($value)
        {
            $value = $this->factory($value);
            !$value->isString() && $value->invalid('String values only');

            return parent::setValue($value->getValue());
        }

        /**
         * @return string
         */
        protected function _default()
        {
            return '';
        }

        /**
         * @param \PowerEcommerce\System\Data\String $value
         * @param \PowerEcommerce\System\Data\String\Strict $strict
         * @return \PowerEcommerce\System\Data\Boolean
         */
        function compare(String $value, Strict $strict = null)
        {
            $strict = new Strict($this->factory($strict)->defaults(new Strict()));

            $true = new Boolean(true);
            $false = new Boolean(false);

            if ($strict->isTrue()) {
                return 0 === strcmp($this, $value) ? $true : $false;
            }
            return 0 === strcasecmp($this, $value) ? $true : $false;
        }

        /**
         * @param \PowerEcommerce\System\Data\String $value
         * @return $this
         */
        function concat(String $value)
        {
            return $this->setValue($this . $value);
        }

        /**
         * @param \PowerEcommerce\System\Data\String $value
         * @param \PowerEcommerce\System\Data\String\Strict $strict
         * @return \PowerEcommerce\System\Data\Boolean
         */
        function contains(String $value, Strict $strict = null)
        {
            $strict = new Strict($this->factory($strict)->defaults(new Strict()));

            $true = new Boolean(true);
            $false = new Boolean(false);

            if ($strict->isTrue()) {
                return false === strpos($this->getValue(), $value->getValue()) ? $false : $true;
            }
            return false === stripos($this->getValue(), $value->getValue()) ? $false : $true;
        }

        /**
         * @param \PowerEcommerce\System\Data\Integer $start
         * @param \PowerEcommerce\System\Data\Integer $length
         * @return \PowerEcommerce\System\Data\String
         */
        function substring(Integer $start, Integer $length = null)
        {
            if (null === $length) {
                return new String((string)substr($this, (string)$start));
            }
            return new String((string)substr($this, (string)$start, (string)$length));
        }

        /**
         * @param \PowerEcommerce\System\Data\Integer $keepLength
         * @param \PowerEcommerce\System\Data\Integer $keepStart
         * @return $this
         */
        function truncate(Integer $keepLength = null, Integer $keepStart = null)
        {
            if (null === $keepStart && null === $keepLength) {
                return $this->setValue('');
            }
            null === $keepStart && $keepStart = new Integer(0);
            return $this->setValue($this->substring($keepStart, $keepLength));
        }

        /**
         * @return \PowerEcommerce\System\Data\Integer
         */
        function length()
        {
            return new Integer(strlen($this));
        }

        /**
         * @param \PowerEcommerce\System\Data\String\Pattern $pattern
         * @return \PowerEcommerce\System\Data\Boolean
         */
        function match(Pattern $pattern)
        {
            $result = preg_match($pattern, $this);
            return new Boolean(1 === $result ? true : false);
        }

        /**
         * @param \PowerEcommerce\System\Data\String $delimiter
         * @param \PowerEcommerce\System\Data\Integer $limit
         * @return \PowerEcommerce\System\Data\Collection
         */
        function explode(String $delimiter, Integer $limit = null)
        {
            $collection = new Collection();

            if (null === $limit) {
                return $collection->setValue($collection->encode(explode($delimiter, $this)));
            }
            return $collection->setValue($collection->encode(explode($delimiter, $this, $limit->toString())));
        }
    }
}