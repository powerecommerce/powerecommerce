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
    use PowerEcommerce\System\Object\Cache;
    use PowerEcommerce\System\Object\InvalidException;

    class Object implements \IteratorAggregate
    {

        /** @type mixed[] */
        protected $_data = [];

        /** @type int */
        protected $_ptr = 0;

        /**
         * @param array
         */
        public function __construct(array $value = [])
        {
            $this->setData($value);
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
                    $class = get_called_class();
                    $args  = print_r($args, true);
                    $this->invalid("Invalid method $class::$name($args)");
            }
        }

        /**
         * @param string $key
         *
         * @return mixed|null
         */
        public function __get($key)
        {
            return $this->get('__' . $key);
        }

        /**
         * @param string $key
         * @param mixed  $value
         *
         * @return $this
         */
        public function __set($key, $value)
        {
            return $this->set('__' . $key, $value);
        }

        /**
         * @return string
         */
        public function __toString()
        {
            return implode(',', $this->getData());
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
         * @param mixed $value
         *
         * @return $this|\PowerEcommerce\System\Object
         */
        public function factory($value = '__clone__')
        {
            if ($value === '__clone__') {
                return (clone $this);
            }
            elseif ($value === null) {
                return new Object();
            }
            elseif (is_array($value)) {
                return new Object($value);
            }
            return new Object([$value]);
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
         * @return array
         */
        public function getData()
        {
            return $this->_data;
        }

        /**
         * @return string
         */
        public function getHashCode()
        {
            return spl_object_hash($this);
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
        protected function underscore($name)
        {
            if (!isset(Cache::$underscore[$name])) {
                Cache::$underscore[$name] = strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $name));
            }
            return Cache::$underscore[$name];
        }
    }
}