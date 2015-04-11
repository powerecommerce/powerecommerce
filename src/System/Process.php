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
    use PowerEcommerce\System\Process\Priority;
    use PowerEcommerce\System\Process\ProcessAlreadyRunningException;
    use PowerEcommerce\System\Process\Shared\Memory;
    use PowerEcommerce\System\Thread\PriorityQueue;

    abstract class Process implements Flow
    {

        /** @type int */
        protected $_priority = Priority::NORMAL;

        /** @type \PowerEcommerce\System\Process\Shared\Memory */
        protected $_psm;

        /** @type \PowerEcommerce\System\Thread\PriorityQueue */
        protected $_queue;

        /** @type int */
        protected $_state = State::UNDEFINED;

        public function __construct()
        {
            $this->_psm   = new Memory();
            $this->_queue = new PriorityQueue();
        }

        /**
         * @return $this
         */
        public function abort()
        {
            /** @type \PowerEcommerce\System\Thread $thread */
            foreach ($this->queue() as $thread) {
                $thread->abort();
            }
            $this->_state = State::TERMINATED;
            return $this;
        }

        /**
         * @param string $source
         * @param int    $priority
         *
         * @return $this
         * @throws \PowerEcommerce\System\Process\ProcessAlreadyRunningException
         */
        public function createThread($source, $priority = null)
        {
            if (State::UNDEFINED !== $this->state()) {
                throw new ProcessAlreadyRunningException;
            }

            /** @type \PowerEcommerce\System\Thread $thread */
            $thread = new $source($this->psm());
            $thread->setPriority($priority);

            $this->queue()->insert($thread, $thread->getPriority());
            return $this;
        }

        /**
         * @return $this
         */
        public function end()
        {
            /** @type \PowerEcommerce\System\Thread $thread */
            foreach ($this->queue() as $thread) {
                $thread->end();
            }
            $this->_state = State::TERMINATED;
            return $this;
        }

        /**
         * @return $this
         */
        public function execute()
        {
            /** @type \PowerEcommerce\System\Thread $thread */
            foreach (clone $this->queue() as $thread) {
                $thread->execute();
            }
            $this->_state = State::EXECUTED;
            return $this;
        }

        /**
         * @return string
         */
        public function getCalledClass()
        {
            return '\\' . get_called_class();
        }

        /**
         * @return int
         */
        public function getPriority()
        {
            return $this->_priority;
        }

        /**
         * @return $this
         */
        public function load()
        {
            /** @type \PowerEcommerce\System\Thread $thread */
            foreach (clone $this->queue() as $thread) {
                $thread->load();
            }
            $this->_state = State::LOADED;
            return $this;
        }

        /**
         * @return \PowerEcommerce\System\Process\Shared\Memory
         */
        public function psm()
        {
            return $this->_psm;
        }

        /**
         * @return \PowerEcommerce\System\Thread\PriorityQueue
         */
        public function queue()
        {
            return $this->_queue;
        }

        /**
         * @param int $priority
         *
         * @return int
         */
        public function setPriority($priority)
        {
            if (null !== $priority) {
                $this->_priority = $priority;
            }
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