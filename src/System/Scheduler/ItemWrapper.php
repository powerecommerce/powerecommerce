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
namespace PowerEcommerce\System\Scheduler {
    use PowerEcommerce\System\Flow;
    use PowerEcommerce\System\Flow\Item;
    use PowerEcommerce\System\Flow\Priority;
    use PowerEcommerce\System\Flow\State;
    use PowerEcommerce\System\Object;

    class ItemWrapper implements Flow, Item
    {

        /** @type array */
        protected $_args;

        /** @type \PowerEcommerce\System\Flow */
        private $_flow;

        /** @type int */
        protected $_priority;

        /** @type \PowerEcommerce\System\Object */
        protected $_registry;

        /** @type string */
        protected $_src;

        /** @type int */
        protected $_state = State::UNDEFINED;

        /**
         * @param string $src
         * @param int    $priority
         * @param array  $args
         */
        public function __construct($src, $priority = Priority::NORMAL, array $args = [])
        {
            $this->_src      = $src;
            $this->_priority = $priority;
            $this->_args     = $args;
            $this->_registry = new Object();
        }

        /**
         * @return \PowerEcommerce\System\Flow
         */
        private function _flow()
        {
            if (State::UNDEFINED === $this->_state) {
                $this->_flow = new $this->_src(...$this->args());

                foreach ($this->registry() as $id => $itemWrapper) {
                    /** @type \PowerEcommerce\System\Flow\Item $this */
                    $this->_flow->set($id, $itemWrapper);
                }
                $this->_state = State::INIT;
            }
            return $this->_flow;
        }

        /**
         * @return \PowerEcommerce\System\Flow
         */
        public function abort()
        {
            return $this->_flow()->abort();
        }

        /**
         * @param string                                       $id
         * @param \PowerEcommerce\System\Scheduler\ItemWrapper $itemWrapper
         *
         * @return $this
         * @throws \PowerEcommerce\System\Scheduler\ItemAlreadyExistsException
         * @throws \PowerEcommerce\System\Scheduler\InvalidItemWrapperArgumentException
         */
        public function add($id, $itemWrapper)
        {
            if ($this->has($id)) {
                throw new ItemAlreadyExistsException;
            }
            return $this->set($id, $itemWrapper);
        }

        /**
         * @param array $args
         * @param bool  $merge
         *
         * @return array
         */
        public function args(array $args = null, $merge = false)
        {
            if (null !== $args) {
                $this->_args = (false === $merge ? $args : array_merge($this->_args, $args));
            }
            return $this->_args;
        }

        /**
         * @param string $id
         *
         * @return $this
         */
        public function del($id)
        {
            $this->registry()->del($id);
            return $this;
        }

        /**
         * @return \PowerEcommerce\System\Flow
         */
        public function end()
        {
            return $this->_flow()->end();
        }

        /**
         * @return \PowerEcommerce\System\Flow
         */
        public function execute()
        {
            return $this->_flow()->execute();
        }

        /**
         * @param string $id
         *
         * @return mixed
         */
        public function get($id)
        {
            return $this->registry()->get($id);
        }

        /**
         * @param string $id
         *
         * @return bool
         */
        public function has($id)
        {
            return $this->registry()->has($id);
        }

        /**
         * @return \PowerEcommerce\System\Flow
         */
        public function load()
        {
            return $this->_flow()->load();
        }

        /**
         * @return int
         */
        public function priority()
        {
            return $this->_priority;
        }

        /**
         * @return \PowerEcommerce\System\Object
         */
        public function registry()
        {
            return $this->_registry;
        }

        /**
         * @param string                                       $id
         * @param \PowerEcommerce\System\Scheduler\ItemWrapper $itemWrapper
         *
         * @return $this
         * @throws \PowerEcommerce\System\Scheduler\InvalidItemWrapperArgumentException
         */
        public function set($id, $itemWrapper)
        {
            if (!($itemWrapper instanceof \PowerEcommerce\System\Scheduler\ItemWrapper)) {
                throw new InvalidItemWrapperArgumentException;
            }
            $this->registry()->set($id, $itemWrapper);
            return $this;
        }
    }
}