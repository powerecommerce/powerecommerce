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
    use PowerEcommerce\System\TypeCode;

    /**
     * Class Collection
     *
     * A type representing a array value.
     *
     * @package PowerEcommerce\System\Data
     */
    class Collection extends Object implements \ArrayAccess, \Iterator
    {
        /**
         * @var array
         */
        protected $value = [];

        /**
         * @var array
         */
        protected $keys = [];

        /**
         * @var int
         */
        protected $position = 0;

        /**
         * @param array|\PowerEcommerce\System\Object $value
         */
        function __construct($value = [])
        {
            $this->setValue($value);
        }

        /**
         * @param array|\PowerEcommerce\System\Object $value
         * @return $this
         */
        function setValue($value)
        {
            $arg = new Argument($value);

            if ($arg->isArray()) return $this->_set($value);
            $arg->strict(TypeCode::OBJECT);

            switch ($value->getTypeCode()) {
                case TypeCode::COLLECTION:
                    /** @var \PowerEcommerce\System\Data\Collection $value */
                    return $this->_set($value->getValue());

                default:
                    return $this->_set([$value]);
            }
        }

        /**
         * @param array $value
         * @return $this
         */
        private function _set(array $value)
        {
            $this->value = $value;
            return $this->_resetKeys();
        }

        /**
         * @return $this
         */
        private function _resetKeys()
        {
            $this->keys = array_keys($this->getValue());
            return $this;
        }

        /**
         * @return array
         */
        function getValue()
        {
            return $this->value;
        }

        /**
         * @param mixed $key
         * @param mixed $value
         * @param string $msg
         * @return $this
         */
        function add($key, $value, $msg = 'This item already exists')
        {
            if ($this[$key]) return (new Argument())->invalid($msg);
            return $this->set($key, $value);
        }

        /**
         * @param mixed $key
         * @param mixed $value
         * @return $this
         */
        function set($key, $value)
        {
            $this[$key] = $value;
            return $this;
        }

        /**
         * @param mixed $key
         * @return mixed
         */
        function get($key)
        {
            return $this[$key];
        }

        /**
         * @param mixed $key
         * @return $this
         */
        function del($key)
        {
            unset($this[$key]);
            return $this;
        }

        /**
         * @return string
         */
        function __toString()
        {
            return implode('', $this->getValue());
        }

        /**
         * @param array|\PowerEcommerce\System\Object $value
         * @param bool $strict
         * @return bool
         */
        function compare($value, $strict = true)
        {
            $value = new Collection($value);
            if ($strict) {
                foreach ($this->getValue() as $_key => $_value) {
                    if ((gettype($_value) !== gettype($value[$_key]))
                        && !(new Argument($_value, $value[$_key]))->isof(TypeCode::STRING | TypeCode::PHP_STRING)
                    ) return false;

                    if ((new Argument($_value))->isof(TypeCode::STRING | TypeCode::PHP_STRING)
                        && !(new String($_value))->compare($value[$_key])
                    ) return false;

                    elseif (!(new Argument($_value))->isof(TypeCode::STRING | TypeCode::PHP_STRING)
                        && $_value !== $value[$_key]
                    ) return false;
                }
                return true;
            }
            foreach ($this->getValue() as $_key => $_value) {
                if ((new Argument($_value, $value[$_key]))->isof(TypeCode::STRING | TypeCode::PHP_STRING)
                    && !(new String($_value))->compare($value[$_key], false)
                ) return false;

                elseif (!(new Argument($_value, $value[$_key]))->isof(TypeCode::STRING | TypeCode::PHP_STRING)
                    && $_value != $value[$_key]
                ) return false;
            }
            return true;
        }

        /**
         * @param array|\PowerEcommerce\System\Object $value
         * @return $this
         */
        function concat($value)
        {
            $value = new Collection($value);
            return $this->setValue(array_merge($this->getValue(), $value->getValue()));
        }

        /**
         * @param mixed $value
         * @param bool $strict
         * @return bool
         */
        function contains($value, $strict = true)
        {
            $value = new Collection($value);
            if ($strict) {
                foreach ($value->getValue() as $_key => $_value) {
                    $valid = false;
                    foreach ($this->getValue() as $_key2 => $_value2) {
                        if ((gettype($_value) !== gettype($_value2))
                            && !(new Argument($_value, $_value2))->isof(TypeCode::STRING | TypeCode::PHP_STRING)
                        ) continue;

                        if (((new Argument($_value))->isof(TypeCode::STRING | TypeCode::PHP_STRING)
                                && (new String($_value))->compare($_value2, $strict)
                            ) || (!(new Argument($_value))->isof(TypeCode::STRING | TypeCode::PHP_STRING)
                                && $_value === $_value2)
                        ) {
                            $valid = true;
                            break;
                        }
                    }
                    if (!$valid) return false;
                }
                return true;
            }
            foreach ($value->getValue() as $_key => $_value) {
                $valid = false;
                foreach ($this->getValue() as $_key2 => $_value2) {
                    if (((new Argument($_value, $_value2))->isof(TypeCode::STRING | TypeCode::PHP_STRING)
                            && (new String($_value))->compare($_value2, $strict)
                        ) || (!(new Argument($_value, $_value2))->isof(TypeCode::STRING | TypeCode::PHP_STRING)
                            && ((new Argument($_value, $_value2))->isObject()
                                || (!(new Argument($_value))->isObject() && !(new Argument($_value2))->isObject()))
                            && $_value == $_value2)
                    ) {
                        $valid = true;
                        break;
                    }
                }
                if (!$valid) return false;
            }
            return true;
        }

        /**
         * @return int TypeCode
         */
        function getTypeCode()
        {
            return TypeCode::COLLECTION;
        }

        /**
         * @param array[]|\PowerEcommerce\System\Object[] $value
         * @return $this
         */
        function join(array $value)
        {
            foreach ($value as $item) $this->concat($item);
            return $this;
        }

        /**
         * @param int $start
         * @param int|null $length
         * @return array
         */
        function slice($start, $length = null)
        {
            return array_slice($this->getValue(), $start, $length);
        }

        /**
         * @param int|null $keepStart
         * @param int|null $keepLength
         * @return $this
         */
        function truncate($keepStart = null, $keepLength = null)
        {
            if (null === $keepStart) return $this->setValue([]);
            return $this->setValue($this->slice($keepStart, $keepLength));
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Whether a offset exists
         * @link http://php.net/manual/en/arrayaccess.offsetexists.php
         * @param mixed $offset <p>
         * An offset to check for.
         * </p>
         * @return boolean true on success or false on failure.
         * </p>
         * <p>
         * The return value will be casted to boolean if non-boolean was returned.
         */
        function offsetExists($offset)
        {
            return isset($this->value[$offset]);
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Offset to retrieve
         * @link http://php.net/manual/en/arrayaccess.offsetget.php
         * @param mixed $offset <p>
         * The offset to retrieve.
         * </p>
         * @return mixed Can return all value types.
         */
        function offsetGet($offset)
        {
            return isset($this->value[$offset]) ? $this->value[$offset] : null;
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Offset to set
         * @link http://php.net/manual/en/arrayaccess.offsetset.php
         * @param mixed $offset <p>
         * The offset to assign the value to.
         * </p>
         * @param mixed $value <p>
         * The value to set.
         * </p>
         * @return void
         */
        function offsetSet($offset, $value)
        {
            if ((new Argument($offset))->isNull()) $this->value[] = $value;
            else $this->value[$offset] = $value;
            $this->_resetKeys();
        }

        /**
         * (PHP 5 &gt;= 5.0.0)<br/>
         * Offset to unset
         * @link http://php.net/manual/en/arrayaccess.offsetunset.php
         * @param mixed $offset <p>
         * The offset to unset.
         * </p>
         * @return void
         */
        function offsetUnset($offset)
        {
            unset($this->value[$offset]);
            $this->_resetKeys();
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
    }
}
