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
    use PowerEcommerce\System\Flow\Item;
    use PowerEcommerce\System\Flow\State;
    use PowerEcommerce\System\Scheduler\InvalidItemWrapperArgumentException;
    use PowerEcommerce\System\Scheduler\ItemAlreadyExistsException;
    use PowerEcommerce\System\Scheduler\PriorityQueue;

    class Scheduler implements Flow, Item
    {

        /** @type array */
        protected $_args;

        /** @type \PowerEcommerce\System\Scheduler\PriorityQueue */
        protected $_queue;

        /** @type \PowerEcommerce\System\Object */
        protected $_registry;

        /** @type int */
        protected $_state = State::UNDEFINED;

        public function __construct(array $args = [])
        {
            $this->_args     = $args;
            $this->_registry = new Object();
            $this->_queue    = new PriorityQueue();
        }

        /**
         * @return $this
         */
        protected function _init()
        {
            /** @type \PowerEcommerce\System\Scheduler\ItemWrapper $flow */
            foreach ($this->registry() as $flow) {
                $flow->args($this->args(), true);
                $this->_queue->insert($flow, $flow->priority());
            }
            $this->_state = State::INIT;
            return $this;
        }

        /**
         * @return $this
         */
        public function abort()
        {
            /** @type \PowerEcommerce\System\Scheduler\ItemWrapper $flow */
            foreach ($this->queue() as $flow) {
                $flow->abort();
            }
            $this->_state = State::TERMINATED;
            return $this;
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
         * @return $this
         */
        public function end()
        {
            /** @type \PowerEcommerce\System\Scheduler\ItemWrapper $flow */
            foreach ($this->queue() as $flow) {
                $flow->end();
            }
            $this->_state = State::TERMINATED;
            return $this;
        }

        /**
         * @return $this
         */
        public function execute()
        {
            /** @type \PowerEcommerce\System\Scheduler\ItemWrapper $flow */
            foreach (clone $this->queue() as $flow) {
                $flow->execute();
            }
            $this->_state = State::EXECUTED;
            return $this;
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
         * @return $this
         */
        public function load()
        {
            /** @type \PowerEcommerce\System\Scheduler\ItemWrapper $flow */
            foreach (clone $this->queue() as $flow) {
                $flow->load();
            }
            $this->_state = State::LOADED;
            return $this;
        }

        /**
         * @return \PowerEcommerce\System\Scheduler\PriorityQueue
         */
        public function queue()
        {
            if (State::UNDEFINED === $this->state()) {
                $this->_init();
            }
            return $this->_queue;
        }

        /**
         * @return \PowerEcommerce\System\Object
         */
        public function registry()
        {
            return $this->_registry;
        }

        /**
         * @return $this
         */
        public function run()
        {
            $this->load();
            $this->execute();
            $this->end();

            return $this;
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

        /**
         * @return int
         */
        public function state()
        {
            return $this->_state;
        }
    }
}