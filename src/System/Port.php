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
    use PowerEcommerce\System\Flow\State;
    use PowerEcommerce\System\Port\PortAlreadyRunningException;
    use PowerEcommerce\System\Port\PriorityQueue;

    class Port implements Flow
    {

        /** @type \PowerEcommerce\System\Object */
        protected $_data;

        /** @type \PowerEcommerce\System\Port\PriorityQueue */
        protected $_queue;

        /** @type int */
        protected $_state = State::UNDEFINED;

        public function __construct()
        {
            $this->_data  = new Object();
            $this->_queue = new PriorityQueue();
        }

        /**
         * @return $this
         */
        public function abort()
        {
            foreach ($this->queue() as $source) {
                $this->process($source)->abort();
            }
            $this->_state = State::TERMINATED;
            return $this;
        }

        /**
         * @param string $source
         * @param int    $priority
         *
         * @return $this
         * @throws \PowerEcommerce\System\Port\PortAlreadyRunningException
         */
        public function createProcess($source, $priority = null)
        {
            if (State::UNDEFINED !== $this->state()) {
                throw new PortAlreadyRunningException;
            }
            if (!$this->_data->has($source)) {
                /** @type \PowerEcommerce\System\Process $process */
                $process = new $source();
                $process->setPriority($priority);

                $this->_data->set($source, $process);
                $this->queue()->insert($source, $process->getPriority());
            }
            return $this;
        }

        /**
         * @return $this
         */
        public function end()
        {
            foreach ($this->queue() as $source) {
                $this->process($source)->end();
            }
            $this->_state = State::TERMINATED;
            return $this;
        }

        /**
         * @return $this
         */
        public function execute()
        {
            foreach (clone $this->queue() as $source) {
                $this->process($source)->execute();
            }
            $this->_state = State::EXECUTED;
            return $this;
        }

        /**
         * @return $this
         */
        public function load()
        {
            foreach (clone $this->queue() as $source) {
                $this->process($source)->load();
            }
            $this->_state = State::LOADED;
            return $this;
        }

        /**
         * @param string $source
         * @param int    $priority
         *
         * @return \PowerEcommerce\System\Process
         */
        public function process($source, $priority = null)
        {
            if (!$this->_data->has($source)) {
                $this->createProcess($source, $priority);
            }
            return $this->_data->get($source);
        }

        /**
         * @return \PowerEcommerce\System\Port\PriorityQueue
         */
        public function queue()
        {
            return $this->_queue;
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