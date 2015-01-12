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
    use PowerEcommerce\System\Object;

    /**
     * Class Collection
     * @package PowerEcommerce\System\Data
     */
    class Collection extends Object implements \Iterator
    {
        /**
         * @var \PowerEcommerce\System\Object[]
         */
        protected $value = [];

        /**
         * @var string[]
         */
        private $keys = [];

        /**
         * @var integer
         */
        private $position = 0;

        /**
         * @param array|\PowerEcommerce\System\Object $value
         */
        function __construct($value = [])
        {
            $this->setValue($value);
        }

        /**
         * @param array $data
         * @return array
         */
        function encode(array $data)
        {
            $encode = [];

            foreach ($data as $key => $value) {
                $encode[(string)$key] = $this->factory($value);
            }

            return $encode;
        }

        /**
         * @param array|\PowerEcommerce\System\Object $value
         * @return $this
         */
        function setValue($value)
        {
            $this->clear();
            return $this->value($value, 'set');
        }

        /**
         * @param array|\PowerEcommerce\System\Object $value
         * @return $this
         */
        function addValue($value)
        {
            return $this->value($value, 'add');
        }

        /**
         * @param \PowerEcommerce\System\Data\String $key
         * @param \PowerEcommerce\System\Object $value
         * @return $this
         */
        function add(String $key, Object $value)
        {
            !($this->get($key) instanceof \PowerEcommerce\System\Data\Blank)
            && $value->invalid('This item already exists');

            return $this->set($key, $value);
        }

        /**
         * @param \PowerEcommerce\System\Data\String $key
         * @param \PowerEcommerce\System\Object $value
         * @return $this
         */
        function set(String $key, Object $value)
        {
            $this->value[(string)$key] = $value;
            return $this;
        }

        /**
         * @param \PowerEcommerce\System\Data\String $key
         * @return \PowerEcommerce\System\Object|\PowerEcommerce\System\Data\Blank
         */
        function get(String $key)
        {
            return isset($this->value[(string)$key])
                ? $this->value[(string)$key] : new Blank();
        }

        /**
         * @param \PowerEcommerce\System\Data\String $key
         * @return $this
         */
        function del(String $key)
        {
            unset($this->value[(string)$key]);
            return $this;
        }

        /**
         * @return $this
         */
        function clear()
        {
            $this->value = [];
            return $this;
        }

        /**
         * @return string
         */
        function __toString()
        {
            return '';
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Return the current element
         * @link http://php.net/manual/en/iterator.current.php
         * @return mixed Can return any type.
         */
        function current()
        {
            return isset($this->keys[$this->position]) ? $this->value[$this->keys[$this->position]] : null;
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Move forward to next element
         * @link http://php.net/manual/en/iterator.next.php
         * @return void Any returned value is ignored.
         */
        function next()
        {
            ++$this->position;
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Return the key of the current element
         * @link http://php.net/manual/en/iterator.key.php
         * @return mixed scalar on success, or null on failure.
         */
        function key()
        {
            return isset($this->keys[$this->position]) ? $this->keys[$this->position] : null;
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Checks if current position is valid
         * @link http://php.net/manual/en/iterator.valid.php
         * @return boolean The return value will be casted to boolean and then evaluated.
         * Returns true on success or false on failure.
         */
        function valid()
        {
            return isset($this->keys[$this->position]) && isset($this->value[$this->keys[$this->position]]);
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Rewind the Iterator to the first element
         * @link http://php.net/manual/en/iterator.rewind.php
         * @return void Any returned value is ignored.
         */
        function rewind()
        {
            $this->position = 0;
        }

        /**
         * @param array|\PowerEcommerce\System\Object $value
         * @param string $func set|add
         * @return Collection
         */
        private function value($value, $func)
        {
            $value = $this->factory($value);

            if ($value->isArray() || $value instanceof \PowerEcommerce\System\Data\Collection) {
                return $this->valueHelper($value->getValue(), $func);
            }

            $value->invalid('Array values only');
        }

        /**
         * @param array $value
         * @param string $func set|add
         * @return $this
         */
        private function valueHelper(array $value, $func)
        {
            foreach ($value as $key => $object) {
                $this->$func(new String((string)$key), $object);
            }
            return $this->resetKeys();
        }

        /**
         * @return $this
         */
        private function resetKeys()
        {
            $this->keys = array_keys($this->getValue());
            return $this;
        }
    }
}