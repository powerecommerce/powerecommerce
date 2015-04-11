<?php

/**
 * Copyright (c) 2015 Tomasz Duda
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
namespace PowerEcommerce\System {
    use PowerEcommerce\System\Object\InvalidException;

    class Object implements \IteratorAggregate, \ArrayAccess
    {

        /** @type mixed[] */
        protected $_data = [];

        /**
         * @param array $data
         */
        public function __construct(array $data = [])
        {
            $this->_data = $data;
        }

        /**
         * @param string $name
         * @param array  $args
         *
         * @return mixed
         */
        public function __call($name, array $args)
        {
            switch (substr($name, 0, 3)) {
                case 'get':
                    $key = $this->underscore(substr($name, 3));
                    return $this->get($key);

                case 'set':
                    $key = $this->underscore(substr($name, 3));
                    return $this->set($key, ...$args);

                case 'add':
                    $key = $this->underscore(substr($name, 3));
                    return $this->add($key, ...$args);

                case 'del':
                    $key = $this->underscore(substr($name, 3));
                    return $this->del($key);

                case 'has':
                    $key = $this->underscore(substr($name, 3));
                    return $this->has($key);

                default:
                    if (is_callable($this->__get($name))) {
                        /** @type callable $callable */
                        $callable = $this->__get($name);
                        return $callable();
                    }
            }
            $class = $this->getCalledClass();
            $args  = print_r($args, true);
            return $this->invalid("Invalid method $class::$name($args)");
        }

        /**
         * @param string $key
         *
         * @return mixed|null
         */
        public function __get($key)
        {
            return $this->get('@' . $key);
        }

        /**
         * @param string $key
         * @param mixed  $value
         *
         * @return $this
         */
        public function __set($key, $value)
        {
            return $this->set('@' . $key, $value);
        }

        /**
         * @return string JSON
         */
        public function __toString()
        {
            return json_encode($this->getData());
        }

        /**
         * @param string $key
         * @param mixed  $value
         *
         * @return $this
         */
        public function add($key, $value)
        {
            $this->has($key) && $this->invalid('Item already exists.');
            return $this->set($key, $value);
        }

        /**
         * @param string $name
         *
         * @return string
         */
        protected function camelize($name)
        {
            return uc_words($name, '');
        }

        /**
         * @return $this
         */
        public function clear()
        {
            $this->value = [];
            return $this;
        }

        /**
         * @param string $key
         *
         * @return $this
         */
        public function del($key)
        {
            unset($this->_data[$key]);
            return $this;
        }

        /**
         * @param string $key
         *
         * @return mixed|null
         */
        public function get($key)
        {
            return $this->has($key) ? $this->_data[$key] : null;
        }

        /**
         * @return string
         */
        public function getCalledClass()
        {
            return get_called_class();
        }

        /**
         * @return string
         */
        public function getCalledClassHash()
        {
            return md5($this->getCalledClass());
        }

        /**
         * @return array
         */
        public function getData()
        {
            return $this->_data;
        }

        /**
         * @return string
         */
        public function getDataHash()
        {
            return md5($this->__toString());
        }

        /**
         * @return string
         */
        public function getHashCode()
        {
            return '\\' . spl_object_hash($this);
        }

        /**
         * @return \ArrayIterator
         */
        public function getIterator()
        {
            return new \ArrayIterator($this->_data);
        }

        /**
         * @param string $key
         *
         * @return bool
         */
        public function has($key)
        {
            return isset($this->_data[$key]);
        }

        /**
         * @param string $msg
         *
         * @throws \PowerEcommerce\System\Object\InvalidException
         * @return \PowerEcommerce\System\Object\InvalidException
         */
        public function invalid($msg = null)
        {
            null === $msg && $msg = $this->getCalledClass();
            throw new InvalidException($msg);
        }

        /**
         * @return int
         */
        public function length()
        {
            return sizeof($this->getData());
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Whether a offset exists
         *
         * @link http://php.net/manual/en/arrayaccess.offsetexists.php
         *
         * @param mixed $offset <p>
         *                      An offset to check for.
         *                      </p>
         *
         * @return boolean true on success or false on failure.
         * </p>
         * <p>
         * The return value will be casted to boolean if non-boolean was returned.
         */
        public function offsetExists($offset)
        {
            return $this->has($offset);
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Offset to retrieve
         *
         * @link http://php.net/manual/en/arrayaccess.offsetget.php
         *
         * @param mixed $offset <p>
         *                      The offset to retrieve.
         *                      </p>
         *
         * @return mixed Can return all value types.
         */
        public function offsetGet($offset)
        {
            if ($this->has($offset)) {
                return $this->get($offset);
            }
            return $this->invalid("'$offset' is not defined.");
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Offset to set
         *
         * @link http://php.net/manual/en/arrayaccess.offsetset.php
         *
         * @param mixed $offset <p>
         *                      The offset to assign the value to.
         *                      </p>
         * @param mixed $value  <p>
         *                      The value to set.
         *                      </p>
         *
         * @return void
         */
        public function offsetSet($offset, $value)
        {
            $this->set($offset, $value);
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Offset to unset
         *
         * @link http://php.net/manual/en/arrayaccess.offsetunset.php
         *
         * @param mixed $offset <p>
         *                      The offset to unset.
         *                      </p>
         *
         * @return void
         */
        public function offsetUnset($offset)
        {
            $this->del($offset);
        }

        /**
         * @param mixed $value
         *
         * @return $this
         */
        public function push($value)
        {
            $this->_data[] = $value;
            return $this;
        }

        /**
         * @param array $value
         *
         * @return $this
         */
        public function pushData(array $value)
        {
            foreach ($value as $item) {
                $this->push($item);
            }
            return $this;
        }

        /**
         * @param string $key
         * @param mixed  $value
         *
         * @return $this
         */
        public function set($key, $value)
        {
            $this->_data[$key] = $value;
            return $this;
        }

        /**
         * @param array $value
         *
         * @return $this
         */
        public function setData(array $value)
        {
            foreach ($value as $key => $val) {
                $this->set($key, $val);
            }
            return $this;
        }

        /**
         * @return string
         */
        public function toString()
        {
            return $this->__toString();
        }

        /**
         * @param string $name
         *
         * @return string
         */
        public function underscore($name)
        {
            return $name;
        }
    }
}